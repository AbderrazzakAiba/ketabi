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
        Schema::create('order_liv', function (Blueprint $table) {
            $table->id('id_demande'); // Corresponds to id_demande
            $table->date('order_date'); // Corresponds to date_demande
            $table->string('status')->default(\App\Enums\OrderStatus::PENDING->value); // Corresponds to etat_demande, using Enum

            // Foreign key for the employee (User) who placed the order
            // Assuming only employees can place orders based on typical workflow
            $table->foreignId('id_User') // Employee's User ID
                  ->constrained('users', 'id_User') // References id_User in users table
                  ->onDelete('cascade'); // Or set null if order should remain if employee deleted

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_liv');
    }
};
