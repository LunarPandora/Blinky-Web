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
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['id_jadwal']);
            $table->dropColumn('id_jadwal');

            $table->integer('id_pertemuan')->primary()->after('id_mhswa');
            $table->foreign('id_pertemuan')->references('id_pertemuan')->on('pertemuan');
        });

        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('nama_buku');
            $table->date('tgl_peminjaman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
