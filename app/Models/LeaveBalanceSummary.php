<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalanceSummary extends Model
{
    use HasFactory;

    protected $table = 'employee_leave_balance_summary';
    protected $guarded = [];

    protected $casts = [
        'employee_id' => 'integer',
        'leave_type' => 'integer',
        'credit' => 'float',
        'debit' => 'float',
        'balance' => 'float',
    ];
}
