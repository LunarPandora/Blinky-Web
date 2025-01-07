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
        Schema::table('dosen', function (Blueprint $table) {
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->after('nidn')->default('Islam');
            $table->enum('gender', ['L', 'P'])->after('nidn')->default('L');
            $table->text('alamat')->after('nidn')->default('-');
            $table->string('no_telp')->after('nidn')->default('-');
            $table->enum('isActive', ['Aktif', 'Tidak aktif'])->after('nidn')->default('Aktif');
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
