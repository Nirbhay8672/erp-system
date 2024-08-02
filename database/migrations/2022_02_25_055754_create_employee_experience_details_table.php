<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExperienceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_experience_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('job_title');
            $table->string('company_name');
            $table->date('joining_date');
            $table->integer('is_still_continue')->default(0);
            $table->date('leaving_date')->nullable();
            $table->string('description');
            $table->string('department');
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
        Schema::dropIfExists('employee_experience_details');
    }
}
