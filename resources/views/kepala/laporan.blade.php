@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Konfirmasi Pengembalian dan Denda</h1>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-xl shadow">

    {{-- 🔍 SEARCH --}}
    <form method="GET" class="mb-4 flex gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="border p-2 rounded w-64">

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
    </form>

    <table class="w-full text-sm text-center border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Cover</th>
                <th class="p-2 border">Buku</th>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Tgl Pinjam</th>
                <th class="p-2 border">Jatuh Tempo</th>
                <th class="p-2 border">Dikembalikan</th>
                <th class="p-2 border">Denda</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)
            @php
                $tglPinjam = \Carbon\Carbon::parse($item->tgl_pinjam);
                $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
                $dikembalikan = $item->tgl_dikembalikan 
                    ? \Carbon\Carbon::parse($item->tgl_dikembalikan) 
                    : now();

                $terlambat = $dikembalikan->gt($jatuhTempo) ? $jatuhTempo->diffInDays($dikembalikan) : 0;
                $denda = $terlambat * 5000;
            @endphp

            <tr class="hover:bg-gray-50">

                {{-- COVER --}}
                <td class="p-2 border">
                    <img 
                        src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}"
                        width="60"
                        class="rounded mx-auto">
                </td>

                {{-- JUDUL --}}
                <td class="border">
                    {{ optional($item->buku)->judul_buku ?? '-' }}
                </td>

                {{-- NAMA --}}
                <td class="border">
                    {{ $item->nama }}
                </td>

                {{-- TGL PINJAM --}}
                <td class="border">
                    {{ $tglPinjam->format('d M Y') }}
                </td>

                {{-- JATUH TEMPO --}}
                <td class="border">
                    {{ $jatuhTempo->format('d M Y') }}
                </td>

                {{-- DIKEMBALIKAN --}}
                <td class="border">
                    {{ $item->tgl_dikembalikan ? $dikembalikan->format('d M Y') : '-' }}
                </td>

                {{-- DENDA --}}
                <td class="border">
                    @if($denda > 0)
                        <span class="text-red-500 font-semibold">
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </span>
                    @else
                        <span class="text-green-500">0</span>
                    @endif
                </td>

        

            </tr>
        @empty
           
        @endforelse
        </tbody>
    </table>
</div>
@endsection