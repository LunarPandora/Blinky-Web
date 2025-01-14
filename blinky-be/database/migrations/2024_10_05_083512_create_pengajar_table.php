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
        Schema::create('pengajar', function (Blueprint $table) {
            $table->integer('id_pengajar')->primary()->autoIncrement();
            $table->smallInteger('id_jurusan');
            $table->string('nm_pengajar');
            $table->string('jabatan');
            $table->string('no_pengajar');
            $table->enum('tipe_pengajar', ['Dosen', 'Guru'])->default('Dosen');
            
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->default('Islam');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->text('alamat')->default('-');
            $table->string('no_telp')->default('-');
            $table->enum('isActive', ['Aktif', 'Tidak aktif'])->default('Aktif');
            $table->timestamps();
        });

        Schema::table('pengajar', function (Blueprint $table) {
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajar');
    }
};
