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

    public function konfirmasiPinjam($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.konfirmasi', compact('buku'));
    }

    
    public function pinjam(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // duplikat pinjam
        $sudahPinjam = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku->id_buku)
            ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_konfirmasi'])
            ->first();

        if ($sudahPinjam) {
            return back()->with('error', 'Kamu sudah mengajukan atau meminjam buku ini!');
        }

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        Peminjaman::create([
            'buku_id' => $buku->id_buku,
            'judul_buku' => $buku->judul_buku,
            'penulis' => $buku->penulis,
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'email' => Auth::user()->email,
            'telepon' => $request->telepon ?? '-',
            'tgl_pinjam' => Carbon::now(),
            'tgl_kembali' => Carbon::now()->addDays(3),
            'status' => 'menunggu'
        ]);

        return redirect()->route('peminjaman.aktif')
            ->with('success', 'Pengajuan dikirim');
    }


    // public function formKembaliAnggota($id)
    // {
    // $pinjam = Peminjaman::with('buku')->findOrFail($id);
    // return view('anggota.form_kembali', compact('pinjam'));
    // }

    public function peminjamanAktif()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->whereIn('status', [
                'menunggu',
                'dipinjam',
                'menunggu_konfirmasi',
                'ditolak' // tampilkan ditolak
            ])
            ->latest()
            ->paginate(5);

        return view('anggota.peminjaman', compact('data'));
    }

    public function riwayat()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->latest()
            ->paginate(5);

        return view('anggota.rekap', compact('data'));
    }

    // public function pengembalian()
    // {
    //     $data = Peminjaman::with('buku')
    //         ->where('user_id', Auth::id())
    //         ->whereIn('status', ['dipinjam', 'menunggu_konfirmasi'])
    //         ->latest()
    //         ->paginate(5);

    //     return view('anggota.pengembalian', compact('data'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'tgl_dikembalikan' => 'required|date'
    //     ]);

    //     $pinjam = Peminjaman::findOrFail($id);

    //     // blok kalau ditolak
    //     if ($pinjam->status == 'ditolak') {
    //         return back()->with('error', 'Data sudah ditolak!');
    //     }

    //     if ($pinjam->status == 'dipinjam') {
    //         $pinjam->status = 'menunggu_konfirmasi';
    //         $pinjam->tgl_dikembalikan = $request->tgl_dikembalikan;
    //         $pinjam->save();
    //     }

    //     return redirect()->route('anggota.preview_kembali', $pinjam->id);
    // }

    // public function previewKembali($id)
    // {
    //     $pinjam = Peminjaman::with('buku')->findOrFail($id);

    //     $jatuhTempo = Carbon::parse($pinjam->tgl_kembali);
    //     $dikembalikan = Carbon::parse($pinjam->tgl_dikembalikan);

    //     $terlambat = $dikembalikan->gt($jatuhTempo)
    //         ? $jatuhTempo->diffInDays($dikembalikan)
    //         : 0;

    //     $denda = $terlambat * 5000;

    //     return view('anggota.preview_kembali', compact('pinjam', 'denda'));
    // }

    // ================== PETUGAS ==================

    public function index(Request $request)
    {
        $data = Peminjaman::with('buku', 'user')
            ->whereIn('status', [
                'menunggu',
                'dipinjam',
                'menunggu_konfirmasi',
                'dikembalikan',
                'ditolak' 
            ])
            ->latest()
            ->paginate(5);

        return view('petugas.peminjaman', compact('data'));
    }

    public function setujui($id)
    {
    $pinjam = Peminjaman::findOrFail($id);

    $buku = \App\Models\Buku::withTrashed()
        ->where('id_buku', $pinjam->buku_id)
        ->first();

    if (!$buku || $buku->deleted_at != null) {
        return back()->with('error', 'Buku sudah dihapus, tidak bisa dikonfirmasi');
    }

    if ($pinjam->status != 'menunggu') {
        return back()->with('error', 'Status tidak valid');
    }

    // 🔥 TAMBAHAN INI (kurangi stok)
    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok habis');
    }

    $buku->decrement('stok', 1);

    $pinjam->status = 'dipinjam';
    $pinjam->save();

    return back()->with('success', 'Peminjaman disetujui');
    }

    // public function konfirmasiKembali($id)
    // {
    //     $pinjam = Peminjaman::findOrFail($id);

    //     if ($pinjam->status == 'ditolak') {
    //         return back()->with('error', 'Sudah ditolak!');
    //     }

    //     if ($pinjam->status != 'menunggu_konfirmasi') {
    //         return back()->with('error', 'Tidak valid');
    //     }

    //     $pinjam->status = 'dikembalikan';
    //     $pinjam->save();

    //     $pinjam->buku->increment('stok');

    //     return back()->with('success', 'Dikonfirmasi');
    // }
public function prosesKembali($id)
{
    $pinjam = Peminjaman::findOrFail($id);

    if ($pinjam->status == 'ditolak') {
        return back()->with('error', 'Data ditolak!');
    }

    if ($pinjam->status != 'dipinjam') {
        return back()->with('error', 'Tidak valid');
    }

    $tglKembali = Carbon::parse($pinjam->tgl_kembali);
    $tglDikembalikan = Carbon::now();

    // hitung keterlambatan
    $terlambat = $tglDikembalikan->gt($tglKembali)
        ? $tglKembali->diffInDays($tglDikembalikan)
        : 0;

    $denda = $terlambat * 5000;

    $pinjam->update([
        'status' => 'dikembalikan',
        'tgl_dikembalikan' => $tglDikembalikan,
        'denda' => $denda // 🔥 simpan ke DB
    ]);

    $pinjam->buku->increment('stok');

    return back()->with('success', 'Berhasil dikembalikan');
}

    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // jangan izinkan kalau sudah selesai
        if ($pinjam->status == 'dikembalikan') {
            return back()->with('error', 'Sudah selesai!');
        }

        $pinjam->status = 'ditolak';
        $pinjam->keterangan = 'Ditolak oleh petugas';
        $pinjam->save();

        return back()->with('success', 'Berhasil ditolak');
    }

    public function konfirmasiPengembalian($id)
    {
    return $this->konfirmasiKembali($id);
    }

    public function pengembalianPetugas(Request $request)
    {
        $query = Peminjaman::with('buku')
            ->whereIn('status', ['dipinjam', 'dikembalikan']);

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('petugas.pengembalian', compact('data'));
    }

    // ================== KEPALA ==================

    public function laporanKepala()
    {
    $data = Peminjaman::with('buku')
        ->whereIn('status', ['dikembalikan', 'ditolak'])
        ->latest()
        ->get();

    return view('kepala.laporan', compact('data'));
    }
}