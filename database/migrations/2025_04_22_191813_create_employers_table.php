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
        Schema::create('employers', function (Blueprint $table) {
            // This table identifies users who are employees and links to the users table.
            $table->foreignId('id_User')
                  ->primary() // Make the user ID the primary key
                  ->constrained('users', 'id_User') // References id_User in users table
                  ->onDelete('cascade'); // If user is deleted, delete employer record

            // Add any employer-specific fields here if needed in the future.

            // No need for separate id or timestamps if it's just identifying users
            // $table->timestamps(); // Remove if not needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
