<?php

namespace Database\Seeders;

use App\Models\EmployeeEducationDetails;
use Illuminate\Database\Seeder;

class EmployeeEducationDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeEducationDetails::truncate();

        EmployeeEducationDetails::create([
            'employee_id' => 1,
            'degree_name' => 'MCA',
            'college_name' => 'XYZ',
            'university_name' => 'GTU',
            'starting_year' => '2019',
            'ending_year' => '2021'
        ]);

        EmployeeEducationDetails::create([
            'employee_id' => 2,
            'degree_name' => 'MBA',
            'college_name' => 'PQR',
            'university_name' => 'GU',
            'starting_year' => '2019',
            'ending_year' => '2021'
        ]);
    }
}
