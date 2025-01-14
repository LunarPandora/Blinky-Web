<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PelajarController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataStudiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatusPresensiController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'get']);
    Route::post('/update', [UserController::class, 'update']);
});

Route::prefix('pelajar')->group(function () {
    Route::get('/', [PelajarController::class, 'fetch']);
    Route::get('/list', [PelajarController::class, 'list']);
    Route::post('/add', [PelajarController::class, 'create']);
    Route::get('/update', [PelajarController::class, 'update']);
    Route::get('/delete', [PelajarController::class, 'delete']);
});

Route::prefix('jurusan')->group(function () {
    Route::get('/', [JurusanController::class, 'fetch']);
    Route::get('/add', [JurusanController::class, 'create']);
    Route::get('/update', [JurusanController::class, 'update']);
    Route::get('/delete', [JurusanController::class, 'delete']);
});

Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'fetch']);
    Route::get('/add', [KelasController::class, 'create']);
    Route::get('/update', [KelasController::class, 'update']);
    Route::get('/delete', [KelasController::class, 'delete']);
});

Route::prefix('mata_studi')->group(function () {
    Route::get('/', [MataStudiController::class, 'fetch']);
    Route::get('/add', [MataStudiController::class, 'create']);
    Route::get('/update', [MataStudiController::class, 'update']);
    Route::get('/delete', [MataStudiController::class, 'delete']);
});

Route::prefix('presensi')->group(function () {
    Route::get('/', [PresensiController::class, 'fetch']);
    Route::get('/list', [PresensiController::class, 'list']);
    // Route::get('/list_pertemuan', [PresensiController::class, 'list_pertemuan']);
    Route::get('/add', [PresensiController::class, 'create']);
    Route::get('/update', [PresensiController::class, 'update']);
    Route::get('/update_ket', [PresensiController::class, 'update_ket']);
    Route::get('/delete', [PresensiController::class, 'delete']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'fetch']);
    Route::get('/add', [RolesController::class, 'create']);
    Route::get('/update', [RolesController::class, 'update']);
    Route::get('/delete', [RolesController::class, 'delete']);
});

Route::prefix('statuspresensi')->group(function () {
    Route::get('/', [StatusPresensiController::class, 'fetch']);
    Route::get('/add', [StatusPresensiController::class, 'create']);
    Route::get('/update', [StatusPresensiController::class, 'update']);
    Route::get('/delete', [StatusPresensiController::class, 'delete']);
});

Route::prefix('pengajar')->group(function () {
    Route::get('/', [PengajarController::class, 'fetch']);
    Route::get('/find', [PengajarController::class, 'fetch_list']);
    Route::get('/get', [PengajarController::class, 'get']);
    Route::get('/add', [PengajarController::class, 'create']);
    Route::get('/update', [PengajarController::class, 'update']);
    Route::get('/delete', [PengajarController::class, 'delete']);
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