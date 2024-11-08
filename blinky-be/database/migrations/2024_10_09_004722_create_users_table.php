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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->primary()->autoIncrement();
            $table->mediumInteger('role_id');
            $table->integer('dosen_id')->nullable();
            $table->integer('mhswa_id')->nullable();
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('mhswa_id')->references('id_mhswa')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
