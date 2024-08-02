<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetails extends Model
{
    use HasFactory;

    protected $casts = [
        'attendance_date' => 'date',
    ];

    protected $fillable=[
        'employee_id',
        'attendance_date',
        'time_in',
        'time_out',
        'time_different'
    ];
}
