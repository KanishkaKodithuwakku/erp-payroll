<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrOvertime extends Model
{
    use HasFactory;

    protected $table = 'hr_overtime';
    
    protected $fillable = ['employee_id', 'hours', 'rate', 'date_overtime'];
    
    public function hrEmployee()
    {
        return $this->belongsTo(HrEmployee::class, 'employee_id');
    }
}