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
            $table->id('id_dosen');
            $table->bigInteger('id_prodi', length: 20);
            $table->bigInteger('id_jabatan', length: 20);
            $table->string('nm_dosen');
            $table->string('nidn');
            // $table->text('foto_dosen');
            $table->timestamps();
        });

        Schema::create('dosen', function (Blueprint $table) {
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan');
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
