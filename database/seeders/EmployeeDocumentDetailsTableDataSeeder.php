<?php

namespace Database\Seeders;

use App\Models\EmployeeDocumentDetails;
use Illuminate\Database\Seeder;

class EmployeeDocumentDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeDocumentDetails::truncate();
    }
}