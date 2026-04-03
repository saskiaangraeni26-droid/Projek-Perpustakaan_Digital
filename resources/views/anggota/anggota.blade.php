@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Daftar Buku</h1>

<!-- 🔍 SEARCH -->
<div class="mb-4">
    <form action="{{ route('buku.index') }}" method="GET" 
          class="flex items-center w-full max-w-xl bg-white rounded-full shadow px-3 py-2">

        <form action="{{ route('buku.index') }}" method="GET" 
      class="flex items-center w-full max-w-md bg-white rounded-lg shadow px-3 py-2">

    <!-- ICON SEARCH -->
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="h-5 w-5 text-gray-400 mr-2" 
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M21 21l-4.35-4.35m1.6-5.4a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>

    <!-- INPUT -->
    <input type="text" name="search" placeholder="Cari buku..."
        value="{{ request('search') }}"
        class="flex-1 outline-none text-sm px-2">

    <!-- BUTTON -->
    <button class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 text-sm">
        Cari
    </button>
    </form>
</div>

<!-- 📚 GRID -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2">

    @forelse($buku as $item)
    <div class="bg-white p-2 rounded-xl shadow-sm w-full">

        <!-- STATUS -->
        <div class="relative flex justify-center">
            <div class="absolute top-0 left-0 -translate-x-2 -translate-y-2 
                {{ $item->stok > 0 ? 'bg-indigo-500' : 'bg-red-500' }}
                text-white px-3 py-1 rounded-r-xl text-xs shadow">

                {{ $item->stok > 0 ? $item->stok . ' Tersedia' : 'Habis' }}
            </div>

            <!-- ✅ GAMBAR (FIX) -->
            <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/150' }}"
     class="rounded-lg w-32 h-48 object-cover">
        </div>

        <!-- DATA -->
        <h3 class="text-sm font-semibold mt-2">
            {{ $item->judul_buku }}
        </h3>

        <p class="text-gray-500 text-xs">
            {{ $item->penulis }}
        </p>

        <p class="text-gray-400 text-xs">
            {{ $item->tahun_terbit }}
        </p>

        <!-- TOMBOL -->
        @if($item->stok > 0)
           <form action="{{ route('anggota.pinjam', $item->id_buku) }}" method="POST">
    @csrf

    <button type="submit"
        class="w-full mt-2 bg-rose-400 text-white py-1 rounded-lg hover:bg-rose-500 text-sm">
        📚 Pinjam
    </button>
</form>
        @else
            <button class="w-full mt-2 bg-gray-300 text-gray-600 py-1 rounded-lg text-sm cursor-not-allowed">
               ❌ Habis
            </button>
        @endif

    </div>

    @empty
        <!-- ❌ kalau kosong -->
        <p class="col-span-5 text-center text-gray-500">
            Buku tidak ditemukan 😢
        </p>
    @endforelse

</div>

@endsection