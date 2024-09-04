<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_attendance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger ('employee_id');
            $table->date('attendance_date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->integer('time_different')->nullable();
            $table->foreign('employee_id')->references('id')->on('users');
            $table->integer('entry_type')->default(0)->comment('0 = system , 1 = manually');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendance_details');
    }
};
