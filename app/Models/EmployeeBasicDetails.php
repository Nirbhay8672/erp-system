<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBasicDetails extends Model
{
    use HasFactory;

    public const GENDER = [
        1 => 'Male',
        2 => 'Female',
        3 => 'Transgender',
    ];

    public const BLOOD_GROUP = [
        'A+' => 'A+',
        'A-' => 'A-',
        'B+' => 'B+',
        'B-' => 'B-',
        'O+' => 'O+',
        'O-' => 'O-',
        'AB+' => 'AB+',
        'AB-' => 'AB-'
    ];

    public const MARITAL_STATUS = [
        1 => 'Single',
        2 => 'Engaged',
        3 => 'Married',
        4 => 'Divorced'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'engagement_or_marriage_anniversary' => 'date',
    ];
    
    protected $fillable=[
        'first_name',
        'last_name',
        'employee_number',
        'designation_id',
        'secondary_email_address',
        'contact_number',
        'emergency_contact_number',
        'permanent_address',
        'current_address',
        'gender',
        'joining_date',
        'date_of_birth',
        'blood_group',
        'marital_status',
        'engagement_or_marriage_anniversary',
        'about',
        'hobbies',
        'reporting_to'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'employee_id');
    }

    public function family()
    {
        return $this->hasOne(EmployeeFamilyDetails::class, 'employee_id', 'id');
    }

    public function bank()
    {
        return $this->hasOne(EmployeeBankDetails::class, 'employee_id', 'id');
    }

    public function education()
    {
        return $this->hasMany(EmployeeEducationDetails::class, 'employee_id', 'id')->orderBy('starting_year', 'DESC');
    }

    public function experience()
    {
        return $this->hasMany(EmployeeExperienceDetails::class, 'employee_id', 'id')->orderBy('joining_date', 'DESC');
    }

    public function getGenderDisplayName() 
    {
        return self::GENDER[$this->gender] ?? 'Unknown';
    }

    public function getBloodGroupDisplayName() 
    {
        return self::BLOOD_GROUP[$this->blood_group] ?? 'Unknown';
    }

    public function getMaritalStatusDisplayName() 
    {
        return self::MARITAL_STATUS[$this->marital_status] ?? 'Unknown';
    }
}