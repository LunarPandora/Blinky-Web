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
            $table->bigInteger('id_absensi')->primary()->autoIncrement();
            $table->mediumInteger('id_kelas');
            $table->integer('id_mhswa');
            $table->integer('id_pertemuan');
            $table->smallInteger('kode_status_absensi');
            $table->dateTime('waktu_absen')->nullable();
            $table->timestamps();
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_mhswa')->references('id_mhswa')->on('mahasiswa');
            $table->foreign('id_pertemuan')->references('id_pertemuan')->on('pertemuan');
            $table->foreign('kode_status_absensi')->references('kode_status_absensi')->on('status_absensi');
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
