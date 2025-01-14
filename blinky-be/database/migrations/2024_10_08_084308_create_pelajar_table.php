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
        Schema::create('pelajar', function (Blueprint $table) {
            $table->integer('id_pelajar')->primary()->autoIncrement();
            $table->mediumInteger('id_kelas');
            $table->smallInteger('id_jurusan');
            $table->string('nm_pelajar');
            $table->string('no_pelajar');
            $table->enum('tipe_pelajar', ['Mahasiswa', 'Siswa'])->default('Mahasiswa');
            $table->mediumInteger('angkatan');
            $table->string('uid_rfid');
            
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->after('angkatan')->default('Islam');
            $table->enum('gender', ['L', 'P'])->after('angkatan')->default('L');
            $table->text('alamat')->after('angkatan')->default('-');
            $table->string('no_telp')->after('angkatan')->default('-');
            $table->enum('isActive', ['Aktif', 'Tidak aktif'])->after('angkatan')->default('Aktif');
            $table->timestamps();
        });

        Schema::table('pelajar', function (Blueprint $table) {
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelajar');
    }
};
