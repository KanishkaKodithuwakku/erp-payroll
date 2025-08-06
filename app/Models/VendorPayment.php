<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    protected $fillable = [
        'vendor_id', 'amount', 'payment_date', 'payment_method',
        'check_number', 'memo', 'branch_id', 'entry_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Supplier::class, 'vendor_id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(VendorPaymentDetail::class, 'vendor_payment_id');
    }
}
