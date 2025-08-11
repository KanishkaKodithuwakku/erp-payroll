<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    use HasFactory;

    protected $table = 'hr_employees';
    
    protected $fillable = [
        'employee_id',
        'firstname',
        'lastname',
        'address',
        'birthdate',
        'contact_info',
        'gender',
        'position_id',
        'schedule_id',
        'photo',
        'created_on'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'created_on' => 'date'
    ];

    public function hrPosition()
    {
        return $this->belongsTo(HrPosition::class, 'position_id');
    }

    public function hrSchedule()
    {
        return $this->belongsTo(HrSchedule::class, 'schedule_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
