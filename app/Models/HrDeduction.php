<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrDeduction extends Model
{
    use HasFactory;

    protected $table = 'hr_deductions';
    
    protected $fillable = ['description', 'amount'];
}