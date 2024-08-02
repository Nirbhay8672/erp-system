<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBasicDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_basic_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('employee_number')->unique();
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designation_details')->onDelete('cascade')->onUpdate('cascade');
            $table->string('secondary_email_address')->nullable();
            $table->text('contact_number');
            $table->text('emergency_contact_number');
            $table->string('permanent_address');
            $table->string('current_address')->nullable();
            $table->string('gender');
            $table->date('joining_date');
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->string('marital_status');
            $table->date('engagement_or_marriage_anniversary')->nullable();
            $table->string('about',500);
            $table->string('hobbies');
            $table->integer('reporting_to')->nullable();
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
        Schema::dropIfExists('employee_basic_details');
    }
}
