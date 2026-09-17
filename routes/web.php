<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\VarianRotiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganSawController;
use App\Http\Controllers\LaporanController;

// Redirect root to dashboard if logged in, otherwise login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// Protected App Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Kriteria
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');

    // Master Varian Roti (Alternatif)
    Route::resource('varian', VarianRotiController::class)->except(['show']);

    // Periode Penilaian Bulanan
    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::get('/periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::post('/periode/{periode}/validasi', [PeriodeController::class, 'validasi'])->name('periode.validasi');
    Route::delete('/periode/{periode}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

    // Input Penilaian Operasional Bulanan (Matriks X)
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/{periode}', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Perhitungan Metode Simple Additive Weighting (SAW)
    Route::get('/perhitungan', [PerhitunganSawController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/{periode}/hitung-ulang', [PerhitunganSawController::class, 'hitungUlang'])->name('perhitungan.hitung-ulang');

    // Laporan Rekomendasi Prioritas Produksi
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{periode}/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});
