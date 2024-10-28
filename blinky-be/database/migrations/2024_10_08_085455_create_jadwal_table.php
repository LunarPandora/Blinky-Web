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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->integerIncrements('id_jadwal')->primary();
            $table->foreignId('id_kelas');
            $table->foreignId('id_dosen');
            $table->foreignId('id_matkul');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->smallInteger('hari');
            $table->timestamps();
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
