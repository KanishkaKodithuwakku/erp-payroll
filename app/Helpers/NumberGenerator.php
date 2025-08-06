<?php

namespace App\Helpers;

use App\Models\Branch;
use App\Models\JobOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NumberGenerator
{

    /**
     * Generate a monthly-resetting code in the format:
     *
     *   {invoicePrefix}/{branchCode}/{YY}/{MM}/{sequence}
     *
     * e.g. INV/KI/25/06/00001
     *
     * @param  string  $tableName       The database table to scan.
     * @param  string  $invoicePrefix   e.g. 'INV'
     * @param  string  $branchCode      e.g. 'KI'
     * @param  string  $codeField       The column name that holds the code.
     * @param  int     $sequenceLength  How many digits the sequence should be (padded).
     * @return string
     */
    public static function generateCode(string $table, string $prefix, string $field, string $branchCode, int $sequenceLength = 5): string
    {
        // 1) Construct date segments
        $now     = Carbon::now();
        $yy      = $now->format('y');   // last two digits of the year (e.g., '25')
        $mm      = $now->format('m');   // two-digit month (e.g., '06')

        // 2) Build the base and LIKE pattern (e.g., "INV/KI/25/06")
        $base    = "{$prefix}/{$branchCode}/{$yy}/{$mm}";
        $like    = "{$base}/%";

        // 3) Grab the most recent matching record
        $lastRow = DB::table($table)
            ->select($field)
            ->where($field, 'like', $like)
            ->orderByDesc('id')
            ->first();

        // 4) Determine next sequence number
        if ($lastRow && preg_match("/(\d{{$sequenceLength}})$/", $lastRow->$field, $m)) {
            $next = (int)$m[1] + 1; // Increment the sequence number
        } else {
            $next = 1; // Start from 1 if no record exists
        }

        // 5) Zero-pad the sequence number and return the full code
        $seqStr = str_pad($next, $sequenceLength, '0', STR_PAD_LEFT);  // Padding with zeros (e.g., '00001')

        // Return the full code in the format: INV/KI/25/06/00001
        return "{$base}/{$seqStr}";
    }


    /**
     * Generate a unique invoice number for the current month and year.
     *
     * Format: INV/{branchCode}/{YY}/{MM}/{sequence}
     * Example: INV/KI/25/06/00001
     *
     * @param  string  $tableName    The table name where the invoice numbers are stored (e.g., 'invoices').
     * @param  string  $prefix       The prefix to be used for the invoice number (e.g., 'INV').
     * @param  string  $branchCode   The branch code (e.g., 'KI').
     * @param  int     $sequenceLength How many digits should the sequence have (default 5).
     * @return string  The generated invoice number.
     */
    public static function generateInvoiceNumber(
        string $tableName,
        string $prefix,
        string $branchCode,
        int $sequenceLength = 5
    ): string {
        // Ensure branchCode is a string (debugging log added)
        $branchCode = (string)$branchCode;
        Log::info("Branch Code Passed: " . $branchCode);  // Debugging log to ensure correct value

        // Get current year and month
        $now = Carbon::now();
        $year = $now->format('y');  // e.g. "25" for 2025
        $month = $now->format('m'); // e.g. "06" for June

        // Build the search pattern (e.g., "INV/KI/25/06/%")
        $searchPattern = "{$prefix}/{$branchCode}/{$year}/{$month}/%";

        // Get the last invoice number for this prefix, branch, year, and month
        $lastInvoice = DB::table($tableName)
            ->where('invoice_number', 'like', $searchPattern)
            ->orderByDesc('id')
            ->first();

        // Extract the last sequence number and increment it
        if ($lastInvoice) {
            // Extract last number and increment
            $lastNumber = intval(substr($lastInvoice->invoice_number, -$sequenceLength)); // Extract last digits
            $nextNumber = str_pad($lastNumber + 1, $sequenceLength, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            // If no previous invoices, start from 1
            $nextNumber = str_pad(1, $sequenceLength, '0', STR_PAD_LEFT); // Start from '00001'
        }

        // Final invoice number
        return "{$prefix}/{$branchCode}/{$year}/{$month}/{$nextNumber}";
    }





    /**
     * Generate a new Job Order number.
     *
     * Format:
     *   JON/{branchCode}/{YY}/{MM}/{sequence}
     * or for re-orders:
     *   JON/{branchCode}/{YY}/{MM}/{sequence}/R{reorderCount}
     *
     * @param  int        $branchId     The branch ID to pull the 2-letter code from.
     * @param  int|null   $reorderId    If set, generate a re-order for this existing JobOrder.
     * @return string|null              The new job_number, or null on error.
     */
    public static function generateJobOrderNumber(int $branchId, int $reorderId = null): ?string
    {
        // 1) Gather our pieces
        $prefix     = 'JON';                             // static prefix
        $branch     = Branch::find($branchId);
        $branchCode = env('BRANCH_CODE', 'default'); // fallback to ID
        $now        = Carbon::now();
        $yy         = $now->format('y');  // e.g. "25"
        $mm         = $now->format('m');  // e.g. "06"
        $zeroCount  = 5;                  // sequence length

        // Build the base for LIKE queries and final string
        $baseCode   = "{$prefix}/{$branchCode}/{$yy}/{$mm}";
        $likePattern = "{$baseCode}/%"; // Pattern for matching all job orders in this month

        // --- Re-order flow ---
        if ($reorderId) {
            $original = JobOrder::find($reorderId);
            if (! $original) {
                session()->flash('error', 'Original Job Order not found.');
                return null;
            }

            // bump its reorder_count
            $newCount = ($original->reorder_count ?? 0) + 1;
            $original->update(['reorder_count' => $newCount]);

            // strip any existing "/R\d+" suffix
            $cleanBase = preg_replace('/\/R\d+$/', '', $original->job_number);

            // Generate the next reorder number
            $candidate = "{$cleanBase}/R{$newCount}";

            // Check if this job number exists (collision check)
            if (JobOrder::where('job_number', $candidate)->exists()) {
                return self::generateJobOrderNumber($branchId, $reorderId); // Retry generating if collision
            }

            return $candidate;
        }

        // --- Fresh Job Order flow ---

        // Find last job for *this month* (excluding any /Rxx re-orders)
        $last = JobOrder::query()
            ->where('job_number', 'like', $likePattern)
            ->where('job_number', 'not like', '%/R%') // Exclude reorders
            ->orderByDesc('id')
            ->first();

        // extract and bump sequence
        $seq = 1;
        if ($last && preg_match("/(\d{{$zeroCount}})$/", $last->job_number, $m)) {
            $seq = (int)$m[1] + 1; // Increment sequence
        }

        $seqStr = str_pad($seq, $zeroCount, '0', STR_PAD_LEFT);

        // Final job number for the fresh order
        return "{$baseCode}/{$seqStr}";
    }




    public static function generateStockTransferCode(
        string $tableName,
        string $prefix,
        string $branchCode,
        string $codeField,
        int    $zeroCount = 5
    ): string
    {
        // 1) two-digit year
        $year = now()->format('y');    // e.g. "25" for 2025
        // 2) build the LIKE pattern (everything before the sequence)
        $pattern = "{$prefix}{$year}{$branchCode}/%";
        // 3) find the last record matching that pattern
        $last = DB::table($tableName)
                  ->where($codeField, 'LIKE', $pattern)
                  ->orderBy('id', 'desc')
                  ->first();

        // 4) extract & increment—or start at 1
        if ($last) {
            // grab the trailing N digits and cast
            $lastSeq = intval(substr($last->$codeField, -$zeroCount));
            $nextSeq = $lastSeq + 1;
        } else {
            $nextSeq = 1;
        }

        // 5) pad and assemble
        $padded = str_pad($nextSeq, $zeroCount, '0', STR_PAD_LEFT);
        $code   = "{$prefix}{$year}{$branchCode}/{$padded}";

        // 6) just in case of a race, recurse if it already exists
        if (DB::table($tableName)->where($codeField, $code)->exists()) {
            return self::generateStockTransferCode(
                $tableName, $prefix, $branchCode, $codeField, $zeroCount
            );
        }

        return $code;
    }









    public static function generatePaymentCode($payment)
    {
        $year = now()->format('y'); // e.g. '25'

        $customerId = $payment->customer_id ?? 0;
        // $entryId = $payment->entry_id ?? 0;
        $branchId = $payment->branch_id ?? 0;
        $id = $payment->id ?? 0;

        return "{$branchId}{$year}/{$id}";
    }
}
