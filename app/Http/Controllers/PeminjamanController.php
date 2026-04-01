<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\BayarDenda;
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
    public function kembaliPetugas(Request $request, $id)
    {
        $request->validate([
            'denda' => 'nullable|numeric|min:0'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        // Update status pengembalian
        $peminjaman->status = 'dikembalikan';
        $peminjaman->tgl_kembali = Carbon::now();
        $peminjaman->save();

        // Simpan denda jika ada
        if ($request->denda) {
            BayarDenda::updateOrCreate(
                ['peminjaman_id' => $peminjaman->id],
                ['jumlah' => $request->denda]
            );
        }

        return redirect()->route('petugas.pengembalian')
            ->with('success', 'Pengembalian berhasil & denda tercatat.');
    }
}