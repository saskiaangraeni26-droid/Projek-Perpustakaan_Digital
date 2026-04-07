<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // tampil profile
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // update profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/dashboard')->with('success', 'Berhasil update');
    }
}