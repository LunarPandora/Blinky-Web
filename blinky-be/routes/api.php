<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KelasController;

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