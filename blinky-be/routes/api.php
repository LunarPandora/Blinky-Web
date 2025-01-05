<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatusAbsensiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/generate_pass', [LoginController::class, 'generate']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'get']);
    Route::post('/update', [UserController::class, 'update']);
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/', [MahasiswaController::class, 'fetch']);
    Route::get('/list', [MahasiswaController::class, 'list']);
    Route::get('/add', [MahasiswaController::class, 'insert']);
    Route::get('/update', [MahasiswaController::class, 'update']);
    Route::get('/delete', [MahasiswaController::class, 'delete']);
});

Route::prefix('prodi')->group(function () {
    Route::get('/', [ProdiController::class, 'fetch']);
    Route::get('/add', [ProdiController::class, 'create']);
    Route::get('/update', [ProdiController::class, 'update']);
    Route::get('/delete', [ProdiController::class, 'delete']);
});

Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'fetch']);
    Route::get('/add', [KelasController::class, 'create']);
    Route::get('/update', [KelasController::class, 'update']);
    Route::get('/delete', [KelasController::class, 'delete']);
});

Route::prefix('matkul')->group(function () {
    Route::get('/', [MatkulController::class, 'fetch']);
    Route::get('/add', [MatkulController::class, 'create']);
    Route::get('/update', [MatkulController::class, 'update']);
    Route::get('/delete', [MatkulController::class, 'delete']);
});

Route::prefix('absensi')->group(function () {
    Route::get('/', [AbsensiController::class, 'fetch']);
    Route::get('/list', [AbsensiController::class, 'list']);
    // Route::get('/list_pertemuan', [AbsensiController::class, 'list_pertemuan']);
    Route::get('/create', [AbsensiController::class, 'create']);
    Route::get('/update', [AbsensiController::class, 'update']);
    Route::get('/update_ket', [AbsensiController::class, 'update_ket']);
    Route::get('/delete', [AbsensiController::class, 'delete']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'fetch']);
    Route::get('/add', [RolesController::class, 'create']);
    Route::get('/update', [RolesController::class, 'update']);
    Route::get('/delete', [RolesController::class, 'delete']);
});

Route::prefix('statusabsensi')->group(function () {
    Route::get('/', [StatusAbsensiController::class, 'fetch']);
    Route::get('/add', [StatusAbsensiController::class, 'create']);
    Route::get('/update', [StatusAbsensiController::class, 'update']);
    Route::get('/delete', [StatusAbsensiController::class, 'delete']);
});

Route::prefix('dosen')->group(function () {
    Route::get('/', [DosenController::class, 'fetch']);
    Route::get('/get', [DosenController::class, 'get']);
    Route::get('/add', [DosenController::class, 'create']);
    Route::get('/update', [DosenController::class, 'update']);
    Route::get('/delete', [DosenController::class, 'delete']);
});

Route::prefix('jadwal')->group(function () {
    Route::get('/', [JadwalController::class, 'fetch']);
    Route::get('/find', [JadwalController::class, 'find']);
    Route::get('/add', [JadwalController::class, 'create']);
    Route::get('/update', [JadwalController::class, 'update']);
    Route::get('/delete', [JadwalController::class, 'delete']);
});

Route::prefix('pertemuan')->group(function () {
    Route::get('/', [PertemuanController::class, 'fetch']);
    Route::get('/find', [PertemuanController::class, 'find']);
});