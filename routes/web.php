<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

// 🔹 HOME
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

// 🔹 AUTH ROUTES
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // BUKU
    Route::resource('buku', BukuController::class)->except(['show']);
    Route::get('/management-buku', [BukuController::class, 'management'])->name('buku.management');
    Route::get('/buku/{id}/tambah-stok', [BukuController::class, 'tambahStok'])->name('buku.tambah_stok');
    Route::post('/buku/{id}/update-stok', [BukuController::class, 'updateStok'])->name('buku.updateStok');

    // ================== ANGGOTA ==================
    // Konfirmasi sebelum pinjam
  
    // Proses pinjam
    Route::post('/pinjam/{id}', [PinjamController::class, 'pinjam'])
        ->name('anggota.pinjam');

    // Riwayat peminjaman
    Route::get('/riwayat', [PinjamController::class, 'riwayat'])
        ->name('peminjaman.riwayat');

    // Halaman pengembalian (anggota)
    Route::get('/pengembalian', [PinjamController::class, 'pengembalian'])
        ->name('pengembalian.buku');

    // Ajukan pengembalian
    Route::put('/pengembalian/{id}', [PinjamController::class, 'update'])
        ->name('pengembalian.update');

    // ================== PETUGAS ==================
    Route::get('/petugas/peminjaman', [PinjamController::class, 'index'])
        ->name('petugas.peminjaman');

    Route::post('/petugas/peminjaman/{id}/setujui', [PinjamController::class, 'setujui'])
        ->name('petugas.setujui');

    Route::post('/petugas/peminjaman/{id}/tolak', [PinjamController::class, 'tolak'])
        ->name('petugas.tolak');

    // Konfirmasi pengembalian (petugas)
    Route::get('/petugas/konfirmasi', [PinjamController::class, 'konfirmasiPengembalian'])
        ->name('petugas.konfirmasi');

    Route::post('/petugas/konfirmasi/{id}', [PinjamController::class, 'konfirmasiKembali'])
        ->name('petugas.konfirmasi.kembali');

    // Form kembalikan buku (petugas)
    Route::get('/petugas/kembalikan/{id}', [PinjamController::class, 'formKembali'])
    ->name('petugas.form_kembali');

    // Proses kembalikan buku (petugas)
    Route::post('/petugas/kembalikan/{id}', [PinjamController::class, 'prosesKembali'])
    ->name('petugas.proses_kembali');

    Route::get('/petugas/pengembalian', [PinjamController::class, 'konfirmasiPengembalian'])
    ->name('petugas.konfirmasi');

    // PETUGAS - tombol konfirmasi
    Route::put('/petugas/pengembalian/{id}', [PinjamController::class, 'konfirmasiKembali'])
    ->name('petugas.konfirmasi.update');

    // ================== DATA ANGGOTA ==================
    Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('data_anggota.petugas');
    Route::get('/tambah-anggota', [AnggotaController::class, 'create']);
    Route::post('/tambah-anggota', [AnggotaController::class, 'store']);
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::post('/pengembalian/{id}', [PinjamController::class, 'prosesKembali'])
    ->name('pengembalian.proses');
    
});

require __DIR__.'/auth.php';