<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman untuk petugas
    public function indexPetugas()
    {
        $data = Peminjaman::with(['buku', 'bayar_denda'])->get();
        return view('petugas.pengembalian', compact('data'));
    }

    // Proses pengembalian + input denda
    use Carbon\Carbon;

public function konfirmasiKembali($id)
{
    $pinjam = Peminjaman::with('buku')->findOrFail($id);

    if ($pinjam->status != 'menunggu_konfirmasi') {
        return back()->with('error', 'Tidak valid');
    }

    $tglKembali = Carbon::parse($pinjam->tgl_kembali); // deadline
    $tglDikembalikan = Carbon::parse($pinjam->tgl_dikembalikan); // dari anggota

    $denda = 0;

    if ($tglDikembalikan->gt($tglKembali)) {
        $telat = $tglKembali->diffInDays($tglDikembalikan);
        $denda = $telat * 1000;
    }

    $pinjam->update([
        'status' => 'dikembalikan',
        'denda' => $denda
    ]);

    $pinjam->buku->increment('stok');

    return back()->with('success', 'Dikonfirmasi. Denda: Rp ' . number_format($denda));
}
}