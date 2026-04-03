<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'anggota') {
            $totalBuku = Buku::count();
            $dipinjam = Peminjaman::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->count();

            $terlambat = Peminjaman::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->whereDate('tgl_kembali', '<', now())
                ->count();

            return view('dashboard.anggota', compact('totalBuku', 'dipinjam', 'terlambat'));

        } elseif ($user->role === 'petugas') {
            $totalBuku = Buku::count();
            $totalDipinjam = Peminjaman::count();
            $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

            return view('dashboard.petugas', compact('totalBuku', 'totalDipinjam', 'totalDikembalikan'));

        } elseif ($user->role === 'kepala') {
            $stats = [
                'totalBuku' => Buku::count(),
                'totalAnggota' => User::where('role', 'anggota')->count(),
                'totalPetugas' => User::where('role', 'petugas')->count(),
                'totalPeminjaman' => Peminjaman::count(),
                'peminjamanTerlambat' => Peminjaman::where('status', 'dipinjam')
                    ->whereDate('tgl_kembali', '<', now())
                    ->count(),
            ];

            return view('dashboard.kepala', compact('stats'));
        }

        abort(403, 'Role tidak valid');
    }
}