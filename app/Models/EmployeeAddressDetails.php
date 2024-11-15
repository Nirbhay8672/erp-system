<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddressDetails extends Model
{
    use HasFactory;

    protected $table = 'employee_address_details';

    protected $guarded = [];
}
