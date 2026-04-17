@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded shadow w-1/2 mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Tambah Anggota</h1>

    <form action="{{ url('/tambah-anggota') }}" method="POST">
        @csrf

        <!-- Nama -->
        <div class="mb-3">
            <label class="block">Nama</label>
            <input type="text" name="nama" class="border p-2 w-full" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="block">Email</label>
            <input type="email" name="email" class="border p-2 w-full" required>
            @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- No HP -->
        <div class="mb-3">
            <label class="block">No HP</label>
            <input type="text" name="no_hp" class="border p-2 w-full" placeholder="08xxxxxxxxxx">
        </div>

        <!-- Tombol -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
        
    </form>
</div>

@endsection