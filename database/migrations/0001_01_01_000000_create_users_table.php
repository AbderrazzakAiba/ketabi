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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_User'); // Corresponds to id_User in Utilisateurs
            $table->string('first_name'); // Corresponds to First_name
            $table->string('last_name'); // Corresponds to Last_name
            $table->string('adress'); // Corresponds to Adress
            $table->string('city'); // Corresponds to City
            $table->string('phone_number'); // Corresponds to Phone_number (string is safer)
            $table->string('email')->unique(); // Corresponds to Email and Login Username
            $table->string('role')->default(\App\Enums\UserRole::STUDENT->value); // Role based on inheritance, using Enum
            $table->string('status')->default(\App\Enums\UserStatus::PENDING->value); // Status for approval, using Enum
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Corresponds to pass_word in Login
            $table->rememberToken();
            $table->timestamps();
            // Removed 'nom', 'adresse' (old names), 'date_naissance'
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
