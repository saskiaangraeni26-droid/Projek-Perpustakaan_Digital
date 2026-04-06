<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // ✅ WAJIB ADA
use App\Models\User;

class KepalaController extends Controller
{
    // ================= PETUGAS =================
    public function petugas()
    {
        $petugas = User::where('role', 'petugas')->get();

        return view('kepala.petugas', compact('petugas'));
    }

    // ================= ANGGOTA =================
    public function dataAnggota(Request $request)
    {
        $search = $request->search;

        $anggota = User::where('role', 'anggota')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('kepala.anggota', compact('anggota', 'search'));
    }

    // ================= UNIVERSAL (PETUGAS & ANGGOTA) =================
    public function dataUser(Request $request, $role)
    {
        $search = $request->search;

        $users = User::where('role', $role)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('kepala.user.index', compact('users', 'role', 'search'));
    }
}