@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="bg-white p-6 rounded-xl shadow-lg text-center w-80">

        <img 
            src="{{ optional($pinjam->buku)->cover ? asset('storage/' . $pinjam->buku->cover) : 'https://via.placeholder.com/150' }}"
            class="w-32 h-44 object-cover mx-auto rounded mb-3">

        <h2 class="font-bold text-lg mb-2">
            {{ optional($pinjam->buku)->judul_buku }}
        </h2>

        <p class="text-sm text-gray-600">
            Penulis: {{ optional($pinjam->buku)->penulis }}
        </p>

        <p class="text-sm text-gray-600">
            Dikembalikan: 
            {{ \Carbon\Carbon::parse($pinjam->tgl_dikembalikan)->format('d M Y') }}
        </p>

        <p class="mt-3 font-semibold">
            Denda:
            @if($denda > 0)
                <span class="text-red-500">
                    Rp {{ number_format($denda, 0, ',', '.') }}
                </span>
            @else
                <span class="text-green-500">0</span>
            @endif
        </p>

        {{-- 🔥 TAMBAHAN PESAN --}}
        @if($denda > 0)
            <p class="mt-2 text-sm text-red-500 font-medium">
                Mohon bayar denda langsung ke perpustakaan
            </p>
        @endif

        <a href="{{ route('pengembalian.buku') }}"
           class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Tutup
        </a>

    </div>

</div>

@endsection