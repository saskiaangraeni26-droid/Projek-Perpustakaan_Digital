@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Data Peminjaman</h1>

<table class="w-full bg-white rounded-lg shadow">

    <thead class="bg-gray-200">
        <tr class="text-center">
            <th class="p-3">Cover</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Buku</th>
            <th class="p-3">Tanggal Pinjam</th>
            <th class="p-3">Tanggal Kembali</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $item)

    <tr class="border-t text-center">

        {{-- COVER --}}
        <td class="p-2">
            <img 
                src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}" 
                width="80" 
                class="rounded mx-auto">
        </td>

        <td class="p-3">{{ $item->nama }}</td>

        <td class="p-3">
            {{ optional($item->buku)->judul_buku }}
        </td>

        <td class="p-3">
            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
        </td>

        <td class="p-3">
            {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}
        </td>

        <!-- STATUS -->
        <td class="p-3">
            @if($item->status == 'menunggu')
                <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-xs">Menunggu</span>
            @elseif($item->status == 'dipinjam')
                <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-xs">Dipinjam</span>
            @else
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Selesai</span>
            @endif
        </td>

        <!-- AKSI -->
        <td class="p-3 space-x-1">

            @if($item->status == 'menunggu')

                <form action="{{ route('petugas.setujui', $item->id) }}" method="POST" class="inline">
                    @csrf
                    <button class="bg-green-500 text-white px-3 py-1 rounded">✔</button>
                </form>

            @else
                <span class="text-gray-400 text-sm">-</span>
            @endif

        </td>

    </tr>

    @empty
    <tr>
        <td colspan="7" class="text-center p-4 text-gray-500">
            Tidak ada data
        </td>
    </tr>
    @endforelse

    </tbody>
</table>

@endsection