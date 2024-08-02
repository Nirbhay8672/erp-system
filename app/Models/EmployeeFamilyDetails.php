<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_id',
        'father_first_name',
        'father_last_name',
        'father_contact_number',
        'mother_first_name',
        'mother_last_name',
        'mother_contact_number'
    ];
}