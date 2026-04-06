<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request; // WAJIB

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        return view('petugas.data_anggota', compact('anggota'));
    }

    public function create()
    {
        return view('petugas.tambah_anggota');
    }

    public function store(Request $request)
    {
    Anggota::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'status' => 1
    ]);

    return redirect('/data-anggota');

    }

    public function edit($id)
    {
    $anggota = Anggota::findOrFail($id);
    return view('petugas.editanggota', compact('anggota'));
    }

    public function show($id)
    {
    $anggota = Anggota::findOrFail($id);
    return view('anggota.show', compact('anggota'));
    }

    public function destroy($id)
{
    $anggota = Anggota::findOrFail($id);
    $anggota->delete();

    return redirect()->back()->with('success', 'Data anggota berhasil dihapus!');
}

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:anggotas,email,' . $id,
        'status' => 'required|boolean',
    ]);

    // Cari anggota berdasarkan id
    $anggota = Anggota::findOrFail($id);

    // Update data
    $anggota->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'status' => $request->status,
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('data_anggota.petugas')->with('success', 'Data anggota berhasil diperbarui!');
}


}