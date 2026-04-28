<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kabid\PersetujuanController;
use App\Http\Controllers\Operator\LaporanController;
use App\Http\Controllers\Operator\PengajuanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petani\NotificationController;
use App\Http\Controllers\Petani\ProfilController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:kelompok_tani'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/pengajuan', [App\Http\Controllers\Petani\PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [App\Http\Controllers\Petani\PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [App\Http\Controllers\Petani\PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [App\Http\Controllers\Petani\PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [NotificationController::class, 'show'])->name('notifikasi.show');
    Route::post('/notifikasi/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifikasi.markAllRead');
});

Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/verify', [PengajuanController::class, 'verify'])->name('pengajuan.verify');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    Route::get('/notifikasi', [App\Http\Controllers\Operator\NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [App\Http\Controllers\Operator\NotificationController::class, 'show'])->name('notifikasi.show');
    Route::post('/notifikasi/mark-all-read', [App\Http\Controllers\Operator\NotificationController::class, 'markAllRead'])->name('notifikasi.markAllRead');
});

Route::middleware(['auth', 'role:kabid'])->prefix('kabid')->name('kabid.')->group(function () {
    Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::get('/persetujuan/{pengajuan}', [PersetujuanController::class, 'show'])->name('persetujuan.show');
    Route::post('/persetujuan/{pengajuan}/approve', [PersetujuanController::class, 'approve'])->name('persetujuan.approve');
    Route::post('/persetujuan/{pengajuan}/reject', [PersetujuanController::class, 'reject'])->name('persetujuan.reject');
    Route::get('/laporan', [App\Http\Controllers\Kabid\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/filter', [App\Http\Controllers\Kabid\LaporanController::class, 'filter'])->name('laporan.filter');
    Route::get('/laporan/print', [App\Http\Controllers\Kabid\LaporanController::class, 'print'])->name('laporan.print');
    Route::get('/notifikasi', [App\Http\Controllers\Kabid\NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [App\Http\Controllers\Kabid\NotificationController::class, 'show'])->name('notifikasi.show');
    Route::post('/notifikasi/mark-all-read', [App\Http\Controllers\Kabid\NotificationController::class, 'markAllRead'])->name('notifikasi.markAllRead');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
