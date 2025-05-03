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
        Schema::create('professors', function (Blueprint $table) {
            // نحدد نوع العمود يدوياً كـ unsignedBigInteger ليطابق النوع الموجود في users
            $table->unsignedBigInteger('id_User')->primary();

            // ثم نحدد العلاقة الخارجية بشكل يدوي
            $table->foreign('id_User')
                  ->references('id_User')
                  ->on('users')
                  ->onDelete('cascade');

            $table->string('affiliation'); // حقل الانتماء
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};
