<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/halo', function () {
    return view('halo');
});

Route::get('/login', [AuthController::class, 'showlogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard/kepsek', [PengajuanController::class, 'indexKepsek'])
    ->middleware('role:kepsek');

Route::get('/dashboard/bendahara', function () {
    return view('dashboard.bendahara');
})->middleware('role:bendahara');

Route::get('/dashboard/civitas', [PengajuanController::class, 'index'])
    ->middleware('role:civitas');

Route::post('/pengajuan/store', [PengajuanController::class, 'store'])
    ->middleware('role:civitas');

Route::get('/pengajuan/create', function () {
    return view('civitas.ajukan');
})->middleware('role:civitas');

Route::post('/pengajuan/{id}/approve', [PengajuanController::class, 'approve'])
    ->middleware('role:kepsek');

Route::post('/pengajuan/{id}/reject', [PengajuanController::class, 'reject'])
    ->middleware('role:kepsek');

