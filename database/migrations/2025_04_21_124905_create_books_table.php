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
        Schema::create('books', function (Blueprint $table) {
            $table->id('id_book'); // Corresponds to id_book
            $table->string('title');
            $table->string('auteur');
            $table->integer('num_page');
            $table->string('num_RGE'); // Assuming RGE is an identifier string
            $table->string('category');
            $table->integer('quantite'); // Total quantity of this book title
            $table->string('etat_liv')->default(\App\Enums\BookStatus::AVAILABLE->value); // Use Enum for status

            // Foreign key for editor (previously publisher)
            $table->foreignId('id_editor')
                  ->constrained('editors', 'id_editor') // References id_editor in editors table
                  ->onDelete('cascade'); // Optional: delete books if editor is deleted

            $table->string('image_path')->nullable(); // Path to the book's image
            $table->string('pdf_path')->nullable(); // Path to the book's PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
