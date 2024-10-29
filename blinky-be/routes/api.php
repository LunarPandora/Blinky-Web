<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/mahasiswa', [MahasiswaController::class, 'fetch']);
Route::get('/mahasiswa/add', [MahasiswaController::class, 'insert']);
Route::get('/mahasiswa/update', [MahasiswaController::class, 'update']);
Route::get('/mahasiswa/delete', [MahasiswaController::class, 'delete']);

Route::get('/prodi', [ProdiController::class, 'fetch']);
Route::get('/prodi/add', [ProdiController::class, 'create']);

Route::get('/kelas', [KelasController::class, 'fetch']);

Route::get('/dosen', [DosenController::class, 'fetch']);
Route::get('/dosen/add', [DosenController::class, 'create']);
Route::get('/dosen/update', [DosenController::class, 'update']);
Route::get('/dosen/delete', [DosenController::class, 'delete']);

Route::get('/jadwal', [JadwalController::class, 'fetch']);
Route::get('/jadwal/add', [JadwalController::class, 'create']);
Route::get('/jadwal/update', [JadwalController::class, 'update']);
Route::get('/jadwal/delete', [JadwalController::class, 'delete']);