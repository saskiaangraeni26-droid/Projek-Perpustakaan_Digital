<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalBuku = Buku::count();

        $dipinjam = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        // 🔥 TERLAMBAT AKTIF
        $terlambat = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->whereDate('tgl_kembali', '<', now())
            ->count();

        return view('dashboard.anggota', compact(
            'totalBuku',
            'dipinjam',
            'terlambat'
        ));
    }
}