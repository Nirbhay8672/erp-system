<?php

namespace Database\Seeders;

use App\Models\EmployeeFamilyDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeFamilyDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_family_details')->truncate();

        EmployeeFamilyDetails::create([
            'employee_id' => 1,
            'father_first_name' => 'PQR',
            'father_last_name' => 'ABC',
            'father_contact_number' => '8548962515',
            'mother_first_name' => 'XYZ',
            'mother_last_name' => 'ABC',
            'mother_contact_number' => '8548942545',
        ]);

        EmployeeFamilyDetails::create([
            'employee_id' => 2,
            'father_first_name' => 'ABC',
            'father_last_name' => 'PQR',
            'father_contact_number' => '9948962515',
            'mother_first_name' => 'LMN',
            'mother_last_name' => 'PQR',
            'mother_contact_number' => '9948942586',
        ]);
    }
}
