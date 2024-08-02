<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        File::deleteDirectory(public_path('uploads'));

        DB::statement("SET foreign_key_checks = 0");

        $this->call([
            DesignationTableDataSeeder::class,
            EmployeeBasicDetailsTableDataSeeder::class,
            UserSeeder::class,
            EmployeeFamilyDetailsTableDataSeeder::class,
            EmployeeEducationDetailsTableDataSeeder::class,
            EmployeeBankDetailsTableDataSeeder::class,
            EmployeeExperienceDetailsTableDataSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
