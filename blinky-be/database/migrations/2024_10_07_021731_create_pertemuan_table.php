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
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->integer('id_pertemuan')->primary()->autoIncrement();
            $table->integer('id_jadwal');
            $table->date('tanggal_pertemuan');
            $table->timestamps();
        });

        Schema::table('pertemuan', function (Blueprint $table) {
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
