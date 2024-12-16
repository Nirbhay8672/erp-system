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
        Schema::create('employee_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('leave_type');
            $table->date('leave_from');
            $table->date('leave_to');
            $table->string('reason');
            $table->integer('status')->default(1)->comment('1|pending, 2|approved, 3|declined, 4|canceled');
            $table->foreign('employee_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('employee_leave_balance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->double('casual_leave');
            $table->double('earned_leave');
            $table->double('sick_leave');
            $table->double('compensatory_off');
            $table->double('work_from_home');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('users');
        });

        Schema::create('employee_leave_balance_summary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('employee_leave_request_id')->nullable();
            $table->integer('leave_type');
            $table->double('credit');
            $table->double('debit');
            $table->double('balance');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('employee_leave_request_id')->references('id')->on('employee_leave_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leave_requests');
        Schema::dropIfExists('employee_leave_balance');
        Schema::dropIfExists('employee_leave_balance_summary');
    }
};
