<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_id',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'account_number'
    ];
}
