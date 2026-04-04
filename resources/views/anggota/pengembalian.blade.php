@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Pengembalian Buku</h1>

<div class="bg-white p-4 rounded-xl shadow">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        @forelse($data as $pinjam)
        <div class="bg-gray-50 rounded-xl shadow p-3 relative">

            <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-3 py-1 rounded-full">
                {{ ucfirst($pinjam->status) }}
            </div>

            <img 
                src="{{ optional($pinjam->buku)->cover ? asset('storage/' . $pinjam->buku->cover) : 'https://via.placeholder.com/150' }}"
                class="rounded-lg w-full h-48 object-cover mb-3">

            <h2 class="font-semibold text-lg">
                {{ optional($pinjam->buku)->judul_buku }}
            </h2>

            <p class="text-gray-600 text-sm">
                {{ optional($pinjam->buku)->penulis }}
            </p>

            <p class="text-gray-500 text-xs mb-3">
                Kembali: 
                {{ $pinjam->tgl_kembali 
                    ? \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') 
                    : '-' }}
            </p>

            <!-- 🔥 FIX DISINI -->
            @if($pinjam->status == 'dipinjam')
            <a href="{{ route('anggota.form_kembali', $pinjam->id) }}"
               class="block text-center w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                Kembalikan
            </a>
            @else
            <button class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg cursor-not-allowed">
                Sudah Dikembalikan
            </button>
            @endif

        </div>
        @empty
        <div class="col-span-4 text-center text-gray-500">
            Tidak ada buku yang harus dikembalikan.
        </div>
        @endforelse

    </div>

</div>

@endsection