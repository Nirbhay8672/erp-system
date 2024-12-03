<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        File::deleteDirectory(public_path('uploads'));

        $this->call([
            DesignationTableDataSeeder::class,
            EmployeeSeeder::class,
            HolidaySeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
