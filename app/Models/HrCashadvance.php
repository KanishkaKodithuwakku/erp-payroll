<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrCashadvance extends Model
{
    use HasFactory;

    protected $table = 'hr_cashadvance';
    
    protected $fillable = [
        'date_advance',
        'employee_id',
        'amount'
    ];

    protected $casts = [
        'date_advance' => 'date',
        'amount' => 'double'
    ];

    /**
     * Get the employee associated with this cash advance
     */
    public function hrEmployee()
    {
        return $this->belongsTo(HrEmployee::class, 'employee_id', 'employee_id');
    }
}