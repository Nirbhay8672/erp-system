<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->double('mobile');
            $table->string('gender');
            $table->date('dob');
            $table->date('doj');
            $table->unsignedBigInteger('designation_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_path');
            $table->text('google2fa_secret')->nullable();
            $table->foreign('designation_id')->references('id')->on('designation_details');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
