<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PinjamController extends Controller
{
    // ================== ANGGOTA ==================

    // 🔹 Konfirmasi sebelum pinjam
    public function konfirmasiPinjam($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.konfirmasi', compact('buku'));
    }

    // 🔹 Proses pinjam
    public function pinjam(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        Peminjaman::create([
            'buku_id' => $buku->id_buku,
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'nis' => Auth::user()->email,
            'telepon' => $request->telepon ?? '-',
            'tgl_pinjam' => Carbon::now(),
            'tgl_kembali' => Carbon::now()->addDays(7),
            'catatan' => $request->catatan,
            'status' => 'menunggu'
        ]);

        return redirect()->route('peminjaman.riwayat')
            ->with('success', 'Pengajuan dikirim, tunggu konfirmasi');
    }

    // 🔹 Riwayat peminjaman
    public function riwayat()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('anggota.denda', compact('data'));
    }

    // 🔹 Halaman pengembalian anggota
    public function pengembalian()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        return view('anggota.pengembalian', compact('data'));
    }

    // 🔹 Ajukan pengembalian
    public function update($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status == 'dipinjam') {
            $pinjam->status = 'menunggu_konfirmasi';
            $pinjam->save();
        }

        return back()->with('success', 'Menunggu konfirmasi petugas');
    }

    // ================== PETUGAS ==================

    // 🔹 Halaman data peminjaman
    public function index()
    {
        $data = Peminjaman::with('buku', 'user')
            ->latest()
            ->get();

        return view('petugas.peminjaman', compact('data'));
    }

    // 🔹 Setujui peminjaman
    public function setujui($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        $pinjam->buku->decrement('stok');

        $pinjam->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // 🔹 Tolak peminjaman
    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // 🔹 Halaman konfirmasi pengembalian petugas
    public function konfirmasiPengembalian()
    {
        $data = Peminjaman::with('buku', 'user')
            ->where('status', 'menunggu_konfirmasi')
            ->latest()
            ->get();

        return view('petugas.konfirmasi', compact('data'));
    }

    // 🔹 Petugas konfirmasi pengembalian
    public function konfirmasiKembali($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->status != 'menunggu_konfirmasi') {
            return back()->with('error', 'Tidak valid');
        }

        $pinjam->status = 'dikembalikan';
        $pinjam->hitungDenda(); // pastikan function ada di model
        $pinjam->save();

        $pinjam->buku->increment('stok');

        return back()->with('success', 'Pengembalian dikonfirmasi');
    }

    // 🔹 Form kembalikan buku (petugas)
public function formKembali($id)
{
    $pinjam = Peminjaman::with('buku', 'user')->findOrFail($id);

    return view('petugas.form_kembali', compact('pinjam'));
}

// 🔹 Proses kembalikan buku (petugas)
public function prosesKembali(Request $request, $id)
{
    $pinjam = Peminjaman::with('buku')->findOrFail($id);

    if ($pinjam->status != 'dipinjam') {
        return back()->with('error', 'Status tidak valid untuk dikembalikan.');
    }

    $pinjam->status = 'dikembalikan';
    $pinjam->hitungDenda(); // pastikan method ini ada di model Peminjaman
    $pinjam->save();

    $pinjam->buku->increment('stok');

    return redirect()->route('petugas.peminjaman')->with('success', 'Buku berhasil dikembalikan.');
}

public function formKembaliAnggota($id)
{
    $pinjam = Peminjaman::with('buku')->findOrFail($id);
    return view('anggota.form_kembali', compact('pinjam'));
}
}