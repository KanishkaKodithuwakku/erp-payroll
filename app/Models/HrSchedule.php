<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrSchedule extends Model
{
    use HasFactory;

    protected $table = 'hr_schedules';
    
    protected $fillable = ['time_in', 'time_out'];
    
    protected $casts = [
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i'
    ];

    public function hrEmployees()
    {
        return $this->hasMany(HrEmployee::class, 'schedule_id');
    }
}