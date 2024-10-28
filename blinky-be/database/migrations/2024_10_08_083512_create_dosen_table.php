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
            $table->integer('id_prodi');
            $table->string('nm_dosen');
            $table->string('nidn');
            $table->integer('id_jabatan');
            // $table->text('foto_dosen');
            $table->timestamps();

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
