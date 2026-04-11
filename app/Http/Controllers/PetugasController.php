<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->search;

    $petugas = User::where('role', 'petugas')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        })
        ->get();

    return view('kepala.petugas', compact('petugas', 'search'));
    }

    public function create()
    {
        return view('kepala.tambahpetugas');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:5'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'petugas'
    ]);

    return redirect()->route('kepala.petugas')
        ->with('success', 'Petugas berhasil ditambahkan');
    }

    public function destroy($id)
    {
    $user = User::findOrFail($id);

    // biar ga bisa hapus diri sendiri
    if ($user->id == auth()->id()) {
        return back()->with('error', 'Tidak bisa hapus akun sendiri');
    }

    $user->delete();

    return redirect()->back()->with('success', 'Petugas berhasil dihapus');
    }
}