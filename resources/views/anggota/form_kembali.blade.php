@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-md">

        <h1 class="text-xl font-semibold mb-4 text-center">
            Form Pengembalian Buku
        </h1>

        {{-- INFO BUKU --}}
        <div class="flex items-center gap-4 mb-4">
            <img 
                src="{{ optional($pinjam->buku)->cover ? asset('storage/' . $pinjam->buku->cover) : 'https://via.placeholder.com/100' }}"
                class="w-16 h-24 object-cover rounded">

            <div>
                <p class="font-semibold">
                    {{ optional($pinjam->buku)->judul_buku ?? '-' }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ optional($pinjam->buku)->penulis ?? '-' }}
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <form action="{{ route('pengembalian.update', $pinjam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block text-sm font-medium mb-1">
                Tanggal Dikembalikan
            </label>

            <input 
                type="date" 
                name="tgl_dikembalikan" 
                class="border p-2 w-full rounded mb-3 focus:outline-none focus:ring-2 focus:ring-green-400" 
                required>

            {{-- INFO --}}
            <p class="text-xs text-gray-500 mb-3">
                * Denda akan dihitung jika melewati tanggal jatuh tempo
            </p>

            <button 
                type="submit" 
                class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">
                Ajukan Pengembalian
            </button>
        </form>

    </div>

</div>

@endsection