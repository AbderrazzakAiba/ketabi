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
        Schema::table('order_liv', function (Blueprint $table) {
            $table->integer('id_User')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('auteur')->nullable();
            $table->string('category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_liv', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('auteur');
            $table->dropColumn('category');
        });
    }
};
