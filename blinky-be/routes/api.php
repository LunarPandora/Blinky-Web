<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatusAbsensiController;
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
Route::get('/prodi/update', [ProdiController::class, 'update']);
Route::get('/prodi/delete', [ProdiController::class, 'delete']);

Route::get('/kelas', [KelasController::class, 'fetch']);
Route::get('/kelas/add', [KelasController::class, 'create']);
Route::get('/kelas/update', [KelasController::class, 'update']);
Route::get('/kelas/delete', [KelasController::class, 'delete']);

Route::get('/matkul', [MatkulController::class, 'fetch']);
Route::get('/matkul/add', [MatkulController::class, 'create']);
Route::get('/matkul/update', [MatkulController::class, 'update']);
Route::get('/matkul/delete', [MatkulController::class, 'delete']);

Route::get('/absensi', [AbsensiController::class, 'fetch']);
Route::get('/absensi/add', [AbsensiController::class, 'create']);
Route::get('/absensi/update', [AbsensiController::class, 'update']);
Route::get('/absensi/delete', [AbsensiController::class, 'delete']);

Route::get('/roles', [RolesController::class, 'fetch']);
Route::get('/roles/add', [RolesController::class, 'create']);
Route::get('/roles/update', [RolesController::class, 'update']);
Route::get('/roles/delete', [RolesController::class, 'delete']);

Route::get('/statusabsensi', [StatusAbsensiController::class, 'fetch']);
Route::get('/statusabsensi/add', [StatusAbsensiController::class, 'create']);
Route::get('/statusabsensi/update', [StatusAbsensiController::class, 'update']);
Route::get('/statusabsensi/delete', [StatusAbsensiController::class, 'delete']);

Route::get('/dosen', [DosenController::class, 'fetch']);
Route::get('/dosen/add', [DosenController::class, 'create']);
Route::get('/dosen/update', [DosenController::class, 'update']);
Route::get('/dosen/delete', [DosenController::class, 'delete']);

Route::get('/jadwal', [JadwalController::class, 'fetch']);
Route::get('/jadwal/add', [JadwalController::class, 'create']);
Route::get('/jadwal/update', [JadwalController::class, 'update']);
Route::get('/jadwal/delete', [JadwalController::class, 'delete']);
