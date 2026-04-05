@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Edit Buku</h1>

<div class="bg-white p-6 rounded-xl shadow w-full max-w-xl">

    <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-4">
            <label class="block text-sm mb-1">Judul Buku</label>
            <input type="text" name="judul_buku" value="{{ $buku->judul_buku }}"
                class="w-full border p-2 rounded" required>
        </div>

        {{-- Penulis --}}
        <div class="mb-4">
            <label class="block text-sm mb-1">Penulis</label>
            <input type="text" name="penulis" value="{{ $buku->penulis }}"
                class="w-full border p-2 rounded" required>
        </div>

        {{-- Tahun --}}
        <div class="mb-4">
            <label class="block text-sm mb-1">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}"
                class="w-full border p-2 rounded" required>
        </div>

        {{-- Stok --}}
        <div class="mb-4">
            <label class="block text-sm mb-1">Stok</label>
            <input type="number" name="stok" value="{{ $buku->stok }}"
                class="w-full border p-2 rounded" required>
        </div>

        {{-- Cover --}}
        <div class="mb-4">
            <label class="block text-sm mb-1">Cover Buku</label>
            <input type="file" name="cover" class="w-full">

            @if($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}" 
                     class="mt-2 w-24 rounded">
            @endif
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-2">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update
            </button>

            <a href="{{ route('buku.management') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
               Batal
            </a>
        </div>

    </form>

</div>

@endsection