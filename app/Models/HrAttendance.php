<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrAttendance extends Model
{
    use HasFactory;

    protected $table = 'hr_attendance';
    
    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'status',
        'time_out',
        'num_hr'
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i',
        'num_hr' => 'double'
    ];

    // Status constants
    const STATUS_PRESENT = 1;
    const STATUS_LATE = 2;
    const STATUS_ABSENT = 3;
    const STATUS_HALF_DAY = 4;

    /**
     * Get the employee associated with this attendance record
     */
    public function hrEmployee()
    {
        return $this->belongsTo(HrEmployee::class, 'employee_id');
    }

    /**
     * Get status as text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PRESENT => 'Present',
            self::STATUS_LATE => 'Late',
            self::STATUS_ABSENT => 'Absent',
            self::STATUS_HALF_DAY => 'Half Day',
            default => 'Unknown',
        };
    }
}