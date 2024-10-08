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
            $table->id('id_absen');
            $table->bigInteger('id_jadwal');
            $table->bigInteger('id_mhswa');
            $table->bigInteger('kode_status_absensi');
            $table->timestamps();
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->foreign('id_jadwal')->references('id')->on('jadwal');
            $table->foreign('id_mhswa')->references('id')->on('mahasiswa');
            $table->foreign('kode_status_absesnsi')->references('kode_status_absensi')->on('status_absen');
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
