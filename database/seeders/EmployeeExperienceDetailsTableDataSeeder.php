<?php

namespace Database\Seeders;

use App\Models\EmployeeExperienceDetails;
use Illuminate\Database\Seeder;

class EmployeeExperienceDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeExperienceDetails::truncate();

        EmployeeExperienceDetails::create([
            'employee_id' => 1,
            'job_title' => 'Laravel Developer',
            'company_name' => 'M-technolab',
            'joining_date' => '2021-09-15',
            'is_still_continue' => 1,
            'description' => 'i am php + laravel  developer',
            'department' => 'Web Developing'
        ]);

        EmployeeExperienceDetails::create([
            'employee_id' => 2,
            'job_title' => 'Laravel + php Developer',
            'company_name' => 'System-technolab',
            'joining_date' => '2020-09-12',
            'is_still_continue' => 1,
            'description' => 'i am php + laravel  developer',
            'department' => 'Web Developing'
        ]);
    }
}
