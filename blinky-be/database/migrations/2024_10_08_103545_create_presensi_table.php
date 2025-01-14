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
        Schema::create('presensi', function (Blueprint $table) {
            $table->bigInteger('id_presensi')->primary()->autoIncrement();
            $table->mediumInteger('id_kelas');
            $table->integer('id_pelajar');
            $table->integer('id_pertemuan');
            $table->smallInteger('kode_status_presensi');
            $table->dateTime('waktu_presensi')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::table('presensi', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_pelajar')->references('id_pelajar')->on('pelajar')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_pertemuan')->references('id_pertemuan')->on('pertemuan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kode_status_presensi')->references('kode_status_presensi')->on('status_presensi')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
