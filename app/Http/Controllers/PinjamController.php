<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PinjamController extends Controller
{
    // 🔥 HALAMAN KONFIRMASI SEBELUM PINJAM
    public function konfirmasi($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.konfirmasi', compact('buku'));
    }

    // 🔥 SIMPAN PENGAJUAN (ANGGOTA)
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
            'nis' => Auth::user()->email, // 🔥 pakai email
            'telepon' => $request->telepon ?? '-',

            'tgl_pinjam' => Carbon::now(),
            'tgl_kembali' => Carbon::now()->addDays(7),

            'catatan' => $request->catatan,
            'status' => 'menunggu' // 🔥 PENTING
        ]);

        return redirect()->route('peminjaman.riwayat')
            ->with('success', 'Pengajuan peminjaman dikirim, tunggu konfirmasi petugas');
    }

    // 🔥 RIWAYAT ANGGOTA
    public function riwayat()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('anggota.denda', compact('data'));
    }

    // 🔥 HALAMAN PETUGAS (LIHAT SEMUA DATA)
    public function index()
    {
        $data = Peminjaman::with('buku', 'user')
            ->latest()
            ->get();

        return view('petugas.peminjaman', compact('data'));
    }

    // 🔥 KONFIRMASI PEMINJAMAN (PETUGAS)
    public function setujui($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // kurangi stok saat disetujui
        $pinjam->buku->decrement('stok');

        $pinjam->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // 🔥 TOLAK PEMINJAMAN
    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // 🔥 ANGGOTA AJUKAN PENGEMBALIAN
    public function kembalikan($id)
{
    $pinjam = Peminjaman::with('buku')->findOrFail($id);

    $today = \Carbon\Carbon::now();
    $tgl_kembali = \Carbon\Carbon::parse($pinjam->tgl_kembali);

    $denda = 0;

    if ($today->gt($tgl_kembali)) {
        $telat = $today->diffInDays($tgl_kembali);
        $denda = $telat * 1000;
    }

    // stok balik
    $pinjam->buku->increment('stok');

    $pinjam->update([
        'status' => 'dikembalikan',
        'denda' => $denda
    ]);

    return back()->with('success', 'Buku dikembalikan. Denda: Rp ' . $denda);
}
}