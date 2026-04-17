<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Category;


class BukuController extends Controller
{
    // ================= ANGGOTA =================
  public function index(Request $request)
{
    $search = $request->search;
    $kategori = $request->kategori;

    $buku = Buku::with('category')

        // SEARCH
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('tahun_terbit', 'like', "%{$search}%");
            });
        })

        // FILTER KATEGORI
        ->when($kategori, function ($query, $kategori) {
            $query->where('category_id', $kategori);
        })

        ->get();



    $kategoriList = Category::all();

    return view('anggota.anggota', compact('buku', 'kategoriList'));
}

    // ================= CREATE =================

    public function create()
    {
    $categories = Category::all();
    return view('petugas.tambah_buku', compact('categories'));
    }

    // ================= STORE =================
public function store(Request $request)
{
    $request->validate([
        'judul_buku' => 'required|unique:buku,judul_buku',
        'penulis' => 'required',
        'tahun_terbit' => 'nullable|numeric',
        'stok' => 'required|numeric|min:0',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $coverPath = null;

    if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('cover_buku', 'public');
    }

    Buku::create([
        'judul_buku' => $request->judul_buku,
        'penulis' => $request->penulis,
        'tahun_terbit' => $request->tahun_terbit,
        'stok' => $request->stok,
        'cover' => $coverPath,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('buku.management')->with('success', 'Buku berhasil ditambahkan');
}
    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
    $request->validate([
        'judul_buku' => 'required|unique:buku,judul_buku,' . $id . ',id_buku',
        'penulis' => 'required',
        'tahun_terbit' => 'nullable|numeric',
        'stok' => 'required|numeric|min:0', 
    ], [
        'judul_buku.unique' => 'Judul buku sudah ada!',
        'stok.min' => 'Stok tidak boleh minus!'
    ]);

    $buku = Buku::findOrFail($id);

    $buku->update([
    'judul_buku' => $request->judul_buku,
    'penulis' => $request->penulis,
    'tahun_terbit' => $request->tahun_terbit,
    'stok' => $request->stok,
    'category_id' => $request->category_id, 
    ]);

    return redirect()->route('buku.management')
        ->with('success', 'Buku berhasil diupdate');
    }
    // ================= DELETE =================
    public function destroy($id)
    {
    $buku = Buku::findOrFail($id);

    $dipinjam = \App\Models\Peminjaman::where('buku_id', $id)
        ->where('status', 'dipinjam')
        ->exists();

    if ($dipinjam) {
        return back()->with('error', 'Buku tidak bisa dihapus karena masih dipinjam!');
    }

    $buku->delete();

    return back()->with('success', 'Buku berhasil dihapus');
    }

    // ================= MANAGEMENT =================
   public function management(Request $request)
    {
    $search = $request->search;

    $buku = Buku::with('category')

        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('tahun_terbit', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        })

        ->get();

    return view('petugas.buku', compact('buku'));
    }

    // ================= TAMBAH STOK =================
    public function tambahStok($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.tambah_stok', compact('buku'));
    }

    public function updateStok(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->stok += $request->stok;
        $buku->save();

        return redirect()->route('buku.management');
    }

    // ================= PINJAM =================
    public function konfirmasi($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.konfirmasi', compact('buku'));
    }

    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->stok > 0) {
            $buku->stok -= 1;
            $buku->save();
        }

        return redirect()->route('buku.index');
    }

    public function kepalaIndex()
{
    $buku = Buku::all();
    return view('kepala.buku', compact('buku'));
}

//-------------------
public function edit($id)
{
    $buku = Buku::findOrFail($id);

    return view('petugas.edit_buku', compact('buku'));
}



}