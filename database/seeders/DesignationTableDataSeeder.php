<?php

namespace Database\Seeders;

use App\Models\DesignationDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DesignationDetails::truncate();

        DesignationDetails::create([ 'name' => 'Web Developer' ]);
        DesignationDetails::create([ 'name' => 'Web Designer' ]);
    }
}
