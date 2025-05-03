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
        Schema::create('etudiants', function (Blueprint $table) {
            // This table stores student-specific data and links to the users table.
            $table->foreignId('id_User')
                  ->primary() // Make the user ID the primary key
                  ->constrained('users', 'id_User') // References id_User in users table
                  ->onDelete('cascade'); // If user is deleted, delete student profile

            $table->string('matricule')->unique();
            $table->string('level'); // Corresponds to Level
            $table->date('academic_year'); // Corresponds to Academic_year
            $table->string('speciality'); // Corresponds to Spéciality

            // No need for separate id or timestamps if it's just extending users table
            // $table->timestamps(); // Remove if not needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
