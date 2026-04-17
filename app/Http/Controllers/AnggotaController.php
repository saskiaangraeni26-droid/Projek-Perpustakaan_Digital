<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    // menampilkan data anggota
    public function index(Request $request)
    {
        $query = \App\Models\User::where('role', 'anggota');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $anggota = $query->get();

        return view('petugas.data_anggota', compact('anggota'));
    }

    // form tambah anggota
    public function create()
    {
        return view('petugas.tambah_anggota');
    }

    // menyimpan data 
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'Email sudah terdaftar!'
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp, 
            'password' => Hash::make('password123'),
            'role' => 'anggota',
        ]);

        return redirect()->route('data_anggota.petugas')
            ->with('success', 'Data anggota berhasil ditambahkan!');
    }

    // untuk detail
    public function show($id)
    {
    $anggota = User::where('role', 'anggota')->findOrFail($id);
    return view('petugas.detailtanggota', compact('anggota'));
    }

    // untuk update 
    public function update(Request $request, $id)
    {
    $anggota = User::where('role', 'anggota')->findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
    ]);

        $anggota->update([
        'name' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
    ]);

    return redirect()->route('data_anggota.petugas')
        ->with('success', 'Data berhasil diupdate!');
    }

}