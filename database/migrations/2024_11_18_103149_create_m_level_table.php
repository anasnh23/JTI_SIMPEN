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
        Schema::create('m_level', function (Blueprint $table) {
            $table->id('level_id'); // Primary key
            $table->string('level_kode', 10)->unique(); // Unique code for kategori_user
            $table->enum('level_nama', ['dosen', 'mahasiswa', 'tendik', 'admin']); // Enum for kategori nama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kategori_user');
    }
};