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
        Schema::create('dosen', function (Blueprint $table) {
            $table->integerIncrements('id_dosen')->primary();
            $table->foreignId('id_prodi');
            $table->string('nm_dosen');
            $table->string('jabatan');
            $table->string('nidn');
            $table->timestamps();
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
