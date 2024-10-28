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
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id_absensi')->primary();
            $table->foreignId('id_mhswa');
            $table->foreignId('id_jadwal');
            $table->dateTime('waktu_absen');
            $table->timestamps();
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_mhswa')->references('id_mhswa')->on('mahasiswa');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal');
            $table->foreign('kode_status_absensi')->references('kode_status_absensi')->on('status_absen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
