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
            'email' => Auth::user()->email,
            'telepon' => $request->telepon ?? '-',
            'tgl_pinjam' => Carbon::now(),
            'tgl_kembali' => Carbon::now()->addDays(7),
            'status' => 'menunggu'
        ]);

        return redirect()->route('peminjaman.aktif')
            ->with('success', 'Pengajuan dikirim, tunggu konfirmasi');
    }

    // 🔹 DATA PEMINJAMAN AKTIF ANGGOTA
    public function peminjamanAktif()
{
    $data = Peminjaman::with('buku')
        ->where('user_id', Auth::id())
        ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_konfirmasi', 'dikembalikan'])
        ->latest()
        ->get();

    return view('anggota.peminjaman', compact('data'));
}

    // 🔹 RIWAYAT (SELESAI)
    public function riwayat()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'dikembalikan')
            ->latest()
            ->get();

        return view('anggota.rekap', compact('data'));
    }

    // 🔹 HALAMAN PENGEMBALIAN
    public function pengembalian()
{
    $data = Peminjaman::with('buku')
        ->where('user_id', Auth::id())
        ->whereIn('status', ['dipinjam', 'menunggu_konfirmasi', 'dikembalikan'])
        ->latest()
        ->get();

    return view('anggota.pengembalian', compact('data'));
}

    // 🔹 FORM INPUT TGL DIKEMBALIKAN
    public function formKembaliAnggota($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);
        return view('anggota.form_kembali', compact('pinjam'));
    }

    // 🔹 AJUKAN PENGEMBALIAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_dikembalikan' => 'required|date'
        ]);

        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status == 'dipinjam') {
            $pinjam->status = 'menunggu_konfirmasi';
            $pinjam->tgl_dikembalikan = $request->tgl_dikembalikan;
            $pinjam->save();
        }

        return redirect()->route('pengembalian.buku')
            ->with('success', 'Pengajuan pengembalian berhasil!');
    }

    // ================== PETUGAS ==================

    // 🔹 DATA PEMINJAMAN PETUGAS
   public function index()
{
    $data = Peminjaman::with('buku', 'user')
        ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_konfirmasi', 'dikembalikan'])
        ->latest()
        ->get();

    return view('petugas.peminjaman', compact('data'));
}

    // 🔹 SETUJUI PEMINJAMAN
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

    // 🔹 KONFIRMASI PENGEMBALIAN (HALAMAN)
    public function konfirmasiPengembalian(Request $request)
{
    $query = Peminjaman::with('buku', 'user')
        ->whereIn('status', ['menunggu_konfirmasi', 'dikembalikan']);

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->latest()->get();

    return view('petugas.konfirmasi', compact('data'));
}

    // 🔹 KONFIRMASI PENGEMBALIAN + HITUNG DENDA
    public function konfirmasiKembali($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->status != 'menunggu_konfirmasi') {
            return back()->with('error', 'Tidak valid');
        }

        $jatuhTempo = Carbon::parse($pinjam->tgl_kembali);
        $dikembalikan = Carbon::parse($pinjam->tgl_dikembalikan);

        $terlambat = $dikembalikan->greaterThan($jatuhTempo)
            ? $jatuhTempo->diffInDays($dikembalikan)
            : 0;

        $pinjam->denda = $terlambat * 5000; // 5000 per hari
        $pinjam->status = 'dikembalikan';
        $pinjam->save();

        $pinjam->buku->increment('stok');

        return back()->with('success', 'Pengembalian dikonfirmasi');
    }

    // 🔹 PROSES LANGSUNG PENGEMBALIAN
    public function prosesKembali($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->status != 'dipinjam') {
            return back()->with('error', 'Status tidak valid.');
        }

        $today = Carbon::now();
        $jatuhTempo = Carbon::parse($pinjam->tgl_kembali);

        $terlambat = $today->greaterThan($jatuhTempo)
            ? $jatuhTempo->diffInDays($today)
            : 0;

        $pinjam->denda = $terlambat * 5000; // 5000 per hari
        $pinjam->status = 'dikembalikan';
        $pinjam->tgl_dikembalikan = $today;
        $pinjam->save();

        $pinjam->buku->increment('stok');

        return redirect()->route('petugas.peminjaman')
            ->with('success', 'Buku berhasil dikembalikan.');
    }

    // ================== KEPALA ==================

    // 🔹 LAPORAN KEPALA
    public function laporanKepala()
    {
        $data = Peminjaman::with('buku')
            ->where('status', 'dikembalikan')
            ->latest()
            ->get();

        return view('kepala.laporan', compact('data'));
    }

    
}