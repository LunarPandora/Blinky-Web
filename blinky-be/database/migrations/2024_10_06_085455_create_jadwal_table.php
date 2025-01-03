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
            $table->integer('id_jadwal')->primary()->autoIncrement();
            $table->mediumInteger('id_kelas');
            $table->integer('id_dosen');
            $table->integer('id_matkul');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->smallInteger('hari');
            $table->smallInteger('pertemuan');
            $table->timestamps();
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkul')->onUpdate('cascade')->onDelete('cascade');
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
