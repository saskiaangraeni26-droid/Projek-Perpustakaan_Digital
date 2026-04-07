@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Buku</h1>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">

@forelse($buku as $item)

<div x-data="{ open: false }" class="bg-white p-3 rounded-xl shadow-sm">
   
    <!-- STATUS -->
    <div class="relative flex justify-center">
        <div class="absolute top-0 left-0 -translate-x-2 -translate-y-2 
            {{ $item->stok > 0 ? 'bg-indigo-500' : 'bg-red-500' }}
            text-white px-2 py-1 rounded-r-xl text-xs shadow">

            {{ $item->stok > 0 ? $item->stok . ' Tersedia' : 'Habis' }}
        </div>

        <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/150' }}"
             class="rounded-lg w-28 h-40 object-cover">
    </div>

    <!-- DATA -->
    <h3 class="text-sm font-semibold mt-2 line-clamp-2">
        {{ $item->judul_buku }}
    </h3>

    <p class="text-gray-500 text-xs">
        {{ $item->penulis }}
    </p>

    <!-- 🔥 BUTTON SEBELAHAN -->
    <div class="flex gap-2 mt-2">

        <!-- DETAIL -->
        <button @click="open = true"
            class="flex-1 bg-blue-400 text-white py-1 rounded-lg hover:bg-blue-500 text-xs">
            Detail
        </button>

        <!-- PINJAM -->
        @if($item->stok > 0)
        <form action="{{ route('anggota.pinjam', $item->id_buku) }}" method="POST" class="flex-1">
            @csrf
            <button type="submit"
                class="w-full bg-rose-400 text-white py-1 rounded-lg hover:bg-rose-500 text-xs">
                Pinjam
            </button>
        </form>
        @else
            <button class="flex-1 bg-gray-300 text-gray-600 py-1 rounded-lg text-xs">
                Habis
            </button>
        @endif

    </div>

    <!-- 🔥 MODAL (KAYAK GAMBAR LU) -->
    <div x-show="open" 
         x-transition
         @click.self="open = false"
         class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">

        <div class="bg-white p-6 rounded-2xl w-80 text-center shadow-lg">

            <!-- COVER -->
            <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/150' }}"
                 class="w-28 h-40 object-cover mx-auto rounded mb-3">

            <!-- JUDUL -->
            <h2 class="font-semibold text-blue-600 mb-2">
                {{ $item->judul_buku }}
            </h2>

            <!-- DETAIL -->
            <p class="text-sm text-gray-600">ID Buku: {{ $item->id_buku }}</p>
            <p class="text-sm text-gray-600">Penulis: {{ $item->penulis }}</p>
            <p class="text-sm text-gray-600">Tahun: {{ $item->tahun_terbit }}</p>
            <p class="text-sm text-gray-600">Stok: {{ $item->stok }}</p>

            <!-- TOMBOL -->
            <button @click="open = false"
                class="mt-4 bg-gray-300 px-4 py-1 rounded">
                Tutup
            </button>

        </div>

    </div>

</div>

@empty
    <p class="col-span-5 text-center text-gray-500">
        Buku tidak ditemukan 😢
    </p>
@endforelse

</div>

@endsection