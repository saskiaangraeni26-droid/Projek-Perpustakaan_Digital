<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // 🔹 TAMPIL DATA
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

    // 🔹 FORM TAMBAH
    public function create()
    {
        return view('petugas.tambah_anggota');
    }

    // 🔹 SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:anggotas,email',
        ]);

        Anggota::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'status' => 1
        ]);

        return redirect()->route('data_anggota.petugas')
            ->with('success', 'Data anggota berhasil ditambahkan!');
    }

    // 🔹 FORM EDIT
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('petugas.editanggota', compact('anggota'));
    }

    // 🔹 DETAIL
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:anggotas,email,' . $id,
        ]);

        $anggota->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('data_anggota.petugas')
            ->with('success', 'Data berhasil diupdate!');
    }

    // 🔹 HAPUS
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('data_anggota.petugas')
            ->with('success', 'Data anggota berhasil dihapus!');
    }
}