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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->integer('id_mhswa')->primary()->autoIncrement();
            $table->integer('nim');
            $table->mediumInteger('id_kelas');
            $table->smallInteger('id_prodi');
            $table->string('nm_mhswa');
            $table->mediumInteger('angkatan');
            $table->string('uid_rfid');
            // $table->text('foto_mhswa');
            $table->timestamps();
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
