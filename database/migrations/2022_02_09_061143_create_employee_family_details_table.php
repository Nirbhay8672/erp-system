<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_family_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('father_first_name');
            $table->string('father_last_name');
            $table->text('father_contact_number');
            $table->string('mother_first_name');
            $table->string('mother_last_name');
            $table->text('mother_contact_number')->nullable();
            $table->foreign('employee_id')->references('id')->on('employee_basic_details')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_family_details');
    }
}
