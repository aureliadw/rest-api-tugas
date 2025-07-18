<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('buku', BukuController::class);
Route::apiResource('peminjam', PeminjamController::class);

Route::post('/peminjaman', [PeminjamanController::class, 'pinjam']);
Route::post('/pengembalian/{id}', [PeminjamanController::class, 'kembalikan']);