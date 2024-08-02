<?php

namespace Database\Seeders;

use App\Models\EmployeeBankDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EmployeeBankDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_bank_details')->truncate();

        EmployeeBankDetails::create([
            'employee_id' => 1,
            'bank_name' => 'SBI',
            'branch_name' => 'Bombay',
            'ifsc_code' => 'SBIN0005943',
            'account_number' => '12345678910'
        ]);

        EmployeeBankDetails::create([
            'employee_id' => 2,
            'bank_name' => 'ICICI',
            'branch_name' => 'Surat',
            'ifsc_code' => 'ICIC0005912',
            'account_number' => '15262485263'
        ]);
    }
}