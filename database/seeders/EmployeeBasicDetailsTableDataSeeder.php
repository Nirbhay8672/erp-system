<?php

namespace Database\Seeders;

use App\Models\EmployeeBasicDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeBasicDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_basic_details')->truncate();
        DB::table('attendance_details')->truncate();

        EmployeeBasicDetails::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'employee_number' => 'TC-0000',
            'designation_id' => 1,
            'secondary_email_address' => 'admin123@gmail.com',
            'contact_number' => '9948516524',
            'emergency_contact_number' => '9948516524',
            'permanent_address' => 'Near apollo hospital',
            'current_address' => 'Near apollo hospital',
            'gender' => '1',
            'joining_date' => '2022-08-15',
            'date_of_birth' => '1998-08-30',
            'blood_group' => 'B+',
            'marital_status' => '1',
            'about' => 'Nothing',
            'hobbies' => 'Music,reading,acting etc'
        ]);

        EmployeeBasicDetails::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'employee_number' => 'TC-0001',
            'designation_id' => 1,
            'secondary_email_address' => 'user123@gmail.com',
            'contact_number' => '9948516546',
            'emergency_contact_number' => '9948516845',
            'permanent_address' => 'Near chowpati',
            'current_address' => 'Near chowpati',
            'gender' => '1',
            'joining_date' => '2022-01-15',
            'date_of_birth' => '1980-08-12',
            'blood_group' => 'AB+',
            'marital_status' => '1',
            'about' => 'Nothing',
            'hobbies' => 'Music,reading etc',
            'reporting_to' => 1
        ]);
    }
}
