@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Data Peminjaman</h1>

<table class="w-full bg-white rounded-lg shadow">

    <thead class="bg-gray-200">
        <tr class="text-center">
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

        <td class="p-3">{{ $item->nama }}</td>
        <td class="p-3">{{ $item->buku->judul_buku }}</td>
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

            @elseif($item->status == 'ditolak')
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Ditolak</span>

            @else
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Dikembalikan</span>
            @endif
        </td>

        <!-- AKSI -->
        @if($item->status == 'menunggu')

    <!-- SETUJUI -->
    <form action="{{ route('petugas.setujui', $item->id) }}" method="POST" class="inline">
        @csrf
        <button class="bg-green-500 text-white px-3 py-1 rounded">✔</button>
    </form>

    <!-- TOLAK -->
    <form action="{{ route('petugas.tolak', $item->id) }}" method="POST" class="inline">
        @csrf
        <button class="bg-red-500 text-white px-3 py-1 rounded">✖</button>
    </form>

@elseif($item->status == 'dipinjam')

    <!-- 🔄 KEMBALIKAN -->
    <form action="{{ route('petugas.kembalikan', $item->id) }}" method="POST">
        @csrf
        <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
            Kembalikan
        </button>
    </form>

@else
    <span class="text-gray-400 text-sm">-</span>
@endif
    </tr>

    @empty
    <tr>
        <td colspan="5" class="text-center p-4 text-gray-500">
            Tidak ada data
        </td>
    </tr>
    @endforelse

    </tbody>
</table>

@endsection