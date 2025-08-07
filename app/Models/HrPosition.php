<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HrPosition extends Model
{
    use HasFactory;

    protected $table = 'hr_positions';
    
    protected $fillable = ['description', 'rate'];

    public function hrEmployees()
    {
        return $this->hasMany(HrEmployee::class, 'position_id');
    }
}
