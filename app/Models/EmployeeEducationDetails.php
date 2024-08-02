<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducationDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_id',
        'degree_name',
        'college_name',
        'university_name',
        'starting_year',
        'ending_year',
        'is_still_pursuing'
    ];
}
