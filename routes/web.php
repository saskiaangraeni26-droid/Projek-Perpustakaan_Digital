<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    // 🔥 DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔥 PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 MANAGEMENT BUKU
    Route::get('/management-buku', [BukuController::class, 'management'])->name('buku.management');

    // 🔥 TAMBAH STOK
    Route::get('/buku/{id}/tambah-stok', [BukuController::class, 'tambahStok'])->name('buku.tambah_stok');
    Route::post('/buku/{id}/update-stok', [BukuController::class, 'updateStok'])->name('buku.updateStok');

    // =====================================
    // 🔥 ANGGOTA (PINJAM BUKU)
    // =====================================

    // konfirmasi sebelum pinjam
    Route::get('/konfirmasi/{id}', [PinjamController::class, 'konfirmasi'])
        ->name('anggota.konfirmasi');

    // proses pinjam
    Route::post('/pinjam/{id}', [PinjamController::class, 'pinjam'])
        ->name('anggota.pinjam');

    // riwayat
    Route::get('/riwayat', [PinjamController::class, 'riwayat'])
        ->name('peminjaman.riwayat');

    // kembalikan buku
    Route::post('/peminjaman/kembali/{id}', [PinjamController::class, 'kembalikan'])
        ->name('peminjaman.kembali');


    // =====================================
    // 🔥 PETUGAS (KELOLA PEMINJAMAN)
    // =====================================

    Route::get('/petugas/peminjaman', [PinjamController::class, 'index'])
        ->name('petugas.peminjaman');

    Route::post('/petugas/peminjaman/{id}/setujui', [PinjamController::class, 'setujui'])
        ->name('petugas.setujui');

    Route::post('/petugas/peminjaman/{id}/tolak', [PinjamController::class, 'tolak'])
        ->name('petugas.tolak');
    
    Route::post('/peminjaman/kembali/{id}', [PinjamController::class, 'kembalikan'])
    ->name('peminjaman.kembalikan');

    Route::post('/petugas/peminjaman/{id}/kembalikan', [PinjamController::class, 'kembalikan'])
    ->name('petugas.kembalikan');

    // =====================================
    // 🔥 CRUD BUKU
    // =====================================

    Route::resource('buku', BukuController::class)->except(['show']);


    // =====================================
    // 🔥 DATA ANGGOTA
    // =====================================

    Route::get('/data-anggota', [AnggotaController::class, 'index'])
        ->name('data_anggota.petugas');

    Route::get('/tambah-anggota', [AnggotaController::class, 'create']);
    Route::post('/tambah-anggota', [AnggotaController::class, 'store']);

    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])
        ->name('anggota.edit');

    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])
        ->name('anggota.show');

    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])
        ->name('anggota.update');

    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])
        ->name('anggota.destroy');

    Route::get('/konfirmasi/{id}', [PinjamController::class, 'konfirmasi'])
    ->name('anggota.konfirmasi');

    Route::post('/pinjam/{id}', [PinjamController::class, 'pinjam'])
        ->name('anggota.pinjam');

    Route::get('/riwayat', [PinjamController::class, 'riwayat'])
        ->name('peminjaman.riwayat');


});

require __DIR__.'/auth.php';