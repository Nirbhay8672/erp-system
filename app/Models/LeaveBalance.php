<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $table = 'employee_leave_balance';
    protected $guarded = [];

    protected $casts = [
        'employee_id' => 'integer',
        'casual_leave' => 'float',
        'earned_leave' => 'float',
        'sick_leave' => 'float',
        'work_from_home' => 'float',
        'compensatory_off' => 'float',
    ];

    public const LEAVE_COLUMN_CASE = [
        1 => 'casual_leave',
        2 => 'earned_leave',
        3 => 'sick_leave',
        4 => 'work_from_home',
        5 => 'compensatory_off',
    ];

    public const LEAVE_COLUMN = [
        'casual_leave' => 1,
        'earned_leave' => 2,
        'sick_leave' => 3,
        'work_from_home' => 4,
        'compensatory_off' => 5,
    ];
}
