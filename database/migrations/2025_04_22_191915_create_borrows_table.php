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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id('id_pret'); // Corresponds to id_pret
            $table->date('borrow_date'); // Corresponds to date_emprunt
            $table->date('return_date')->nullable(); // Corresponds to date_retour, nullable until returned
            $table->date('due_date')->nullable(); // Expected return date, important for tracking
            $table->string('type')->default(\App\Enums\LoanType::EXTERNAL->value); // Corresponds to type_empr, using Enum
            $table->string('status')->default(\App\Enums\BorrowStatus::ACTIVE->value); // Corresponds to etat_empr, using Enum
            $table->integer('nbr_liv_empr')->nullable(); // Adding back based on user request (Number of books borrowed by user at this time?)

            // Foreign key for User (Utilisateur)
            $table->foreignId('id_User')
                  ->constrained('users', 'id_User') // References id_User in users table
                  ->onDelete('cascade');

            // Foreign key for Copy (Exemplaire)
            $table->foreignId('id_exemplaire')
                  ->constrained('copies', 'id_exemplaire') // References id_exemplaire in copies table (corrected table name)
                  ->onDelete('cascade');

            $table->timestamps();
            // Removed nbr_liv_empr, lieu_naissance, date_naissance as they seem incorrect here or handled by relationships
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
