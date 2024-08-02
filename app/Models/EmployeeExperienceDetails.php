<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExperienceDetails extends Model
{
    use HasFactory;

    protected $casts = [
        'joining_date' => 'date',
        'leaving_date' => 'date',
    ];
    
    protected $fillable=[
        'employee_id',
        'job_title',
        'company_name',
        'joining_date',
        'is_still_continue',
        'leaving_date',
        'description',
        'department'
    ];
}
