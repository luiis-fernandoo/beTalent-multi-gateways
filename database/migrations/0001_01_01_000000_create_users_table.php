<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->autoIncrement();
            $table->string('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->autoIncrement()->unique();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::create('custom_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->autoIncrement()->unique();
            $table->string('token')->unique();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('expiration_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
