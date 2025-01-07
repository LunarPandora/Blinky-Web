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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->after('angkatan')->default('Islam');
            $table->enum('gender', ['L', 'P'])->after('angkatan')->default('L');
            $table->text('alamat')->after('angkatan')->default('-');
            $table->string('no_telp')->after('angkatan')->default('-');
            $table->enum('isActive', ['Aktif', 'Tidak aktif'])->after('angkatan')->default('Aktif');
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
