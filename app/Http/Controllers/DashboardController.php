<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

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

        
        $denda = Peminjaman::where('user_id', $user->id)
            ->sum('denda');

        $peminjamanTerakhir = Peminjaman::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $jatuhTempo = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->whereBetween('tgl_kembali', [now(), now()->addDays(3)])
            ->get();

        return view('dashboard.anggota', compact(
            'totalBuku',
            'dipinjam',
            'terlambat',
            'peminjamanTerakhir',
            'jatuhTempo',
            'denda' 
        ));

        } elseif ($user->role === 'petugas') {

        $totalBuku = Buku::count();

        $totalDipinjam = Peminjaman::count();

        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tgl_kembali', '<', now())
            ->count();

        $menunggu = Peminjaman::where('status', 'menunggu')->count();

        $peminjamanHariIni = Peminjaman::whereDate('tgl_pinjam', now())->count();

        $pengembalianHariIni = Peminjaman::whereDate('tgl_dikembalikan', now())->count();

        $terbaru = Peminjaman::with('buku')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.petugas', compact(
            'totalBuku',
            'totalDipinjam',
            'totalDikembalikan',
            'terlambat',
            'menunggu',
            'peminjamanHariIni',
            'pengembalianHariIni',
            'terbaru'
    ));

    }  elseif ($user->role === 'kepala') {

                $stats = [
                    'totalBuku' => Buku::count(),
                    'totalAnggota' => User::where('role', 'anggota')->count(),
                    'totalPetugas' => User::where('role', 'petugas')->count(),
                    'totalPeminjaman' => Peminjaman::count(),

                    'peminjamanTerlambat' => Peminjaman::where('status', 'dipinjam')
                        ->whereDate('tgl_kembali', '<', now())
                        ->count(),

                    'peminjamanHariIni' => Peminjaman::whereDate('tgl_pinjam', Carbon::today())->count(),

                    'pengembalianHariIni' => Peminjaman::whereDate('tgl_dikembalikan', Carbon::today())->count(),
                ];

                $recent = Peminjaman::with(['user', 'buku'])
                    ->latest()
                    ->take(5)
                    ->get();

                return view('dashboard.kepala', compact('stats', 'recent'));
            }

        abort(403, 'Role tidak valid');
    }
}