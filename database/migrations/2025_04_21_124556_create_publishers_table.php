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
        // Rename table from 'publishers' to 'editors' to match the new diagram
        Schema::create('editors', function (Blueprint $table) {
            $table->id('id_editor'); // Corresponds to id_editor
            $table->string('name_ed');
            $table->string('adress_ed');
            $table->string('city_ed');
            $table->string('email_ed')->unique();
            $table->string('tel_ed'); // Diagram shows int, but string is safer for phone numbers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editors'); // Drop the correct table name
    }
};
