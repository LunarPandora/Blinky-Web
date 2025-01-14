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
            $table->integer('pengajar_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->string('email');
            $table->string('password');
            $table->text('user_picture');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pengajar_id')->references('id_pengajar')->on('pengajar')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pelajar_id')->references('id_pelajar')->on('pelajar')->onUpdate('cascade')->onDelete('cascade');
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
