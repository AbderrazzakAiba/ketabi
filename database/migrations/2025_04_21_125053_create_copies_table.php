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
        // Create the copies table
        Schema::create('copies', function (Blueprint $table) {
            $table->id('id_exemplaire'); // Corresponds to id_exemplaire
            $table->date('date_achat');
            $table->string('etat_copy_liv')->default(\App\Enums\CopyStatus::AVAILABLE->value); // Use Enum for status

            // Foreign key for book
            $table->foreignId('id_book')
                  ->constrained('books', 'id_book') // References id_book in books table
                  ->onDelete('cascade'); // Optional: delete copies if book is deleted

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies'); // Drop the correct table name
    }
};
