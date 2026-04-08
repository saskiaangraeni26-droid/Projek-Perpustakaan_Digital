<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// 🔹 HOME
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

// 🔹 AUTH
Route::middleware(['auth'])->group(function () {

    // ================== DASHBOARD ==================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ================== PROFILE ==================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // ================== BUKU ==================
    Route::resource('buku', BukuController::class)->except(['show']);
    Route::get('/management-buku', [BukuController::class, 'management'])->name('buku.management');
    Route::get('/buku/{id}/tambah-stok', [BukuController::class, 'tambahStok'])->name('buku.tambah_stok');
    Route::post('/buku/{id}/update-stok', [BukuController::class, 'updateStok'])->name('buku.updateStok');

    // ================== ANGGOTA ==================

    // 🔹 Pinjam buku
    Route::post('/pinjam/{id}', [PinjamController::class, 'pinjam'])
        ->name('anggota.pinjam');

    // 🔹 Riwayat (HANYA yang sudah selesai)
    Route::get('/riwayat', [PinjamController::class, 'riwayat'])
        ->name('peminjaman.riwayat');

    // 🔹 Halaman pengembalian
    Route::get('/pengembalian', [PinjamController::class, 'pengembalian'])
        ->name('pengembalian.buku');

    // 🔹 Form isi tanggal pengembalian
    Route::get('/anggota/kembali/{id}', [PinjamController::class, 'formKembaliAnggota'])
        ->name('anggota.form_kembali');

    // 🔹 Ajukan pengembalian
    Route::put('/pengembalian/{id}', [PinjamController::class, 'update'])
        ->name('pengembalian.update');

    Route::get('/peminjaman', [PinjamController::class, 'peminjamanAktif'])
    ->name('peminjaman.aktif');

    Route::get('/preview-kembali/{id}', [PinjamController::class, 'previewKembali'])
    ->name('anggota.preview_kembali');


    // ================== PETUGAS ==================

    // 🔹 Data peminjaman (menunggu + dipinjam)
    Route::get('/petugas/peminjaman', [PinjamController::class, 'index'])
        ->name('petugas.peminjaman');

    // 🔹 Setujui pinjam
    Route::put('/petugas/peminjaman/{id}/setujui', [PinjamController::class, 'setujui'])
    ->name('petugas.setujui');

    // 🔹 Konfirmasi pengembalian + denda
    Route::get('/petugas/konfirmasi', [PinjamController::class, 'konfirmasiPengembalian'])
        ->name('petugas.konfirmasi');

    Route::put('/petugas/konfirmasi/{id}', [PinjamController::class, 'konfirmasiKembali'])
        ->name('petugas.konfirmasi.kembali');


    // ================== DATA ANGGOTA ==================
    Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('data_anggota.petugas');
    Route::get('/tambah-anggota', [AnggotaController::class, 'create']);
    Route::post('/tambah-anggota', [AnggotaController::class, 'store']);
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');



    // ================== kepala ==================
   Route::middleware(['auth'])->group(function () {

    Route::get('/kepala/laporan-peminjaman', [LaporanController::class, 'laporanPeminjaman'])
        ->name('kepala.laporanpeminjaman');

    Route::get('/kepala/laporan-pengembalian', [LaporanController::class, 'laporanPengembalian'])
        ->name('kepala.laporanpengembalian');

    });

    Route::get('/kepala/buku', [BukuController::class, 'kepalaIndex'])->name('kepala.buku');

    Route::get('/kepala/petugas', [BukuController::class, 'kepalaIndex'])->name('kepala.petugas');

    Route::middleware(['auth'])->group(function () {

    Route::get('/kepala/petugas', [KepalaController::class, 'petugas'])
        ->name('kepala.petugas');

    });

    Route::get('/kepala/anggota', [KepalaController::class, 'dataAnggota'])
    ->name('kepala.anggota');
    
    Route::get('/kepala/laporan-pengembalian/pdf', [LaporanController::class, 'exportPdf'])
    ->name('kepala.laporanpengembalian.pdf');

    Route::get('/kepala/laporan-peminjaman/pdf', 
    [LaporanController::class, 'exportPeminjamanPdf']
)->name('kepala.laporanpeminjaman.pdf');

});

require __DIR__.'/auth.php';