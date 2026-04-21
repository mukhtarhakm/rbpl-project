<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PenerimaanDanaController;
use App\Http\Controllers\RKASController;
use App\Http\Controllers\ReportController;

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

// Route removed to avoid conflict with PengajuanController@indexBendahara

Route::get('/dashboard/civitas', [PengajuanController::class, 'index'])
    ->middleware('role:civitas');

Route::post('/pengajuan/store', [PengajuanController::class, 'store'])
    ->middleware('role:civitas');

// Route moved to PengajuanController@create below
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])
    ->middleware('role:civitas');

Route::post('/pengajuan/{id}/approve', [PengajuanController::class, 'approve'])
    ->middleware('role:kepsek');

Route::post('/pengajuan/{id}/reject', [PengajuanController::class, 'reject'])
    ->middleware('role:kepsek');

Route::get('/dashboard/bendahara', [PengajuanController::class, 'indexBendahara'])
    ->middleware('role:bendahara');

Route::post('/pengajuan/{id}/cairkan', [PengajuanController::class, 'cairkan'])
    ->middleware('role:bendahara');

Route::get('/pencairan', [PengajuanController::class, 'pencairanList'])
    ->middleware('role:bendahara');

Route::get('/pencairan/detail/{id}', [PengajuanController::class, 'pencairanDetail'])
    ->middleware('role:bendahara');

Route::get('/transaksi', [PenerimaanDanaController::class, 'transaksi'])
    ->middleware('role:bendahara');

Route::post('/realisasi-langsung', [PengajuanController::class, 'realisasiLangsung'])
    ->middleware('role:bendahara');

Route::post('/pengajuan/{id}/upload-bukti', [PengajuanController::class, 'uploadBukti'])
    ->middleware('role:civitas');

Route::get('/civitas/upload-bukti', [PengajuanController::class, 'uploadBuktiList'])
    ->middleware('role:civitas');

Route::get('/civitas/upload-bukti/{id}', [PengajuanController::class, 'uploadBuktiForm'])
    ->middleware('role:civitas');

Route::get('/penerimaan', [PenerimaanDanaController::class, 'index'])
    ->middleware('role:bendahara');

Route::get('/penerimaan/create', [PenerimaanDanaController::class, 'create'])
    ->middleware('role:bendahara');

Route::post('/penerimaan/store', [PenerimaanDanaController::class, 'store'])
    ->middleware('role:bendahara');

Route::middleware(['auth', 'role:kepsek'])->group(function () {
    // Pengajuan & Laporan (Kepsek)
    Route::get('/dashboard/kepsek/persetujuan', [PengajuanController::class, 'persetujuan']);
    Route::get('/dashboard/kepsek/persetujuan/{type}/{id}', [PengajuanController::class, 'persetujuanDetail']);
    Route::post('/dashboard/kepsek/approve/{id}', [PengajuanController::class, 'approve']);
    Route::post('/dashboard/kepsek/reject/{id}', [PengajuanController::class, 'reject']);
    Route::post('/dashboard/kepsek/rkas/approve/{id}', [RKASController::class, 'approve']);
    Route::post('/dashboard/kepsek/rkas/reject/{id}', [RKASController::class, 'reject']);

    // Route Laporan
    Route::get('/dashboard/kepsek/laporan', [ReportController::class, 'index']);
    Route::get('/dashboard/kepsek/laporan/download', [ReportController::class, 'downloadPDF']);
    Route::get('/dashboard/kepsek/notifikasi', [PengajuanController::class, 'notificationHistory']);
});

Route::get('/civitas/riwayat', [PengajuanController::class, 'riwayat'])
    ->middleware('role:civitas');

Route::get('/civitas/notifications', [PengajuanController::class, 'notifications'])
    ->middleware('role:civitas');

Route::get('/rkas/status', [RKASController::class, 'index'])->middleware('role:bendahara,kepsek');
Route::get('/rkas/status/{id}', [RKASController::class, 'show'])->middleware('role:bendahara,kepsek');
Route::get('/rkas', [RKASController::class, 'create'])->middleware('role:bendahara');
Route::post('/rkas/store', [RKASController::class, 'store'])->middleware('role:bendahara');

Route::post('/rkas/{id}/approve', [RKASController::class, 'approve'])
    ->middleware('role:kepsek');

Route::post('/rkas/{id}/reject', [RKASController::class, 'reject'])
    ->middleware('role:kepsek');