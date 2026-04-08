<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporanPengembalian(Request $request)
    {
        $query = Peminjaman::whereNotNull('tgl_dikembalikan')->with('buku');

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tgl_dikembalikan', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        }

        $data = $query->paginate(10)->withQueryString();

        return view('kepala.laporanpengembalian', compact('data'));
    }

    public function exportPdf(Request $request)
    {
        set_time_limit(120); // 🔥 biar gak timeout

        $query = Peminjaman::whereNotNull('tgl_dikembalikan')->with('buku');

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tgl_dikembalikan', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        }

        // 🔥 BATASI DATA + HITUNG DI CONTROLLER
        $data = $query->limit(50)->get()->map(function ($item) {
            $tglPinjam = Carbon::parse($item->tgl_pinjam);
            $jatuhTempo = Carbon::parse($item->tgl_kembali);
            $dikembalikan = Carbon::parse($item->tgl_dikembalikan);

            $terlambat = $dikembalikan->gt($jatuhTempo)
                ? $jatuhTempo->diffInDays($dikembalikan)
                : 0;

            $item->terlambat = $terlambat;
            $item->denda = $terlambat * 5000;

            return $item;
        });

        $pdf = Pdf::loadView('kepala.pdfpengembalian', compact('data', 'request'));

        return $pdf->stream('laporan_pengembalian.pdf');
    }

   public function exportPeminjamanPdf(Request $request)
{
    $query = Peminjaman::with('buku')
        ->whereNull('tgl_dikembalikan');

    if ($request->filled('dari') && $request->filled('sampai')) {
        $query->whereBetween('tgl_pinjam', [
            $request->dari . ' 00:00:00',
            $request->sampai . ' 23:59:59'
        ]);
    }

    $data = $query->get();

    $pdf = Pdf::loadView('kepala.pdfpeminjaman', compact('data'));

    return $pdf->stream('laporan_peminjaman.pdf');
}

public function laporanPeminjaman(Request $request)
{
    $query = Peminjaman::with('buku')
        ->whereNull('tgl_dikembalikan');

    if ($request->filled('dari') && $request->filled('sampai')) {
        $query->whereBetween('tgl_pinjam', [
            $request->dari . ' 00:00:00',
            $request->sampai . ' 23:59:59'
        ]);
    }

    $data = $query->paginate(10)->withQueryString();

    return view('kepala.laporanpeminjaman', compact('data'));
}
}