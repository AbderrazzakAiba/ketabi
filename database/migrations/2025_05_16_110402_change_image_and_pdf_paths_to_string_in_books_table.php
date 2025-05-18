<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'image_path') && Schema::hasColumn('books', 'pdf_path')) {
                if (DB::getDoctrineSchemaManager()->hasTable('books')) {
                    $sm = DB::getDoctrineSchemaManager();
                    $imageOptions = $sm->listTableDetails('books')->getColumn('image_path')->toArray();
                    $pdfOptions = $sm->listTableDetails('books')->getColumn('pdf_path')->toArray();
                    $imageOptions['type'] = new \Doctrine\DBAL\Types\StringType();
                    $pdfOptions['type'] = new \Doctrine\DBAL\Types\StringType();
                    $table->string('image_path', 255)->nullable()->change();
                    $table->string('pdf_path', 255)->nullable()->change();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'image_path') && Schema::hasColumn('books', 'pdf_path')) {
                if (DB::getDoctrineSchemaManager()->hasTable('books')) {
                    $sm = DB::getDoctrineSchemaManager();
                    $imageOptions = $sm->listTableDetails('books')->getColumn('image_path')->toArray();
                    $pdfOptions = $sm->listTableDetails('books')->getColumn('pdf_path')->toArray();
                    $imageOptions['type'] = new \Doctrine\DBAL\Types\BlobType();
                    $pdfOptions['type'] = new \Doctrine\DBAL\Types\BlobType();
                    $table->longBlob('image_path')->nullable()->change();
                    $table->longBlob('pdf_path')->nullable()->change();
                }
            }
        });
    }
};
