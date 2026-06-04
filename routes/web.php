<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::resource('kelas', KelasController::class)
            ->parameters(['kelas' => 'kelas']);

        Route::resource('siswa', SiswaController::class)
            ->parameters(['siswa' => 'siswa']);

        Route::resource('guru', GuruController::class)
            ->parameters(['guru' => 'guru']);

        Route::resource('mata-pelajaran', MataPelajaranController::class)
            ->parameters(['mata-pelajaran' => 'mataPelajaran']);
    });

    Route::middleware('role:admin,guru')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.export-csv');
    });

    Route::resource('nilai', NilaiController::class)
        ->parameters(['nilai' => 'nilai']);
});