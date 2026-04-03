@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Pengembalian Buku & Denda</h1>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-2xl shadow-md">
    <table class="w-full text-sm text-center border rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Judul Buku</th>
                <th class="p-3">Nama Anggota</th>
                <th class="p-3">Tgl Pinjam</th>
                <th class="p-3">Tgl Kembali</th>
                <th class="p-3">Status</th>
                <th class="p-3">Denda</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr class="border-t hover:bg-gray-50">
                <td>{{ optional($item->buku)->judul_buku ?? 'Buku tidak ditemukan' }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') : '-' }}</td>
                <td>
    @if($item->status == 'menunggu_konfirmasi')
        <form action="{{ route('petugas.konfirmasi.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                Konfirmasi Pengembalian
            </button>
        </form>
    @else
        <span class="text-gray-500">-</span>
    @endif
</td>
                <td>
                    @php
                        $denda = $item->denda ?? 0;
                    @endphp
                    <span class="text-red-500 font-semibold">Rp {{ number_format($denda) }}</span>
                </td>
                <td>
                    @if($item->status == 'menunggu_konfirmasi')
                        <form action="{{ route('petugas.konfirmasi.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-4 text-gray-500">Tidak ada data peminjaman</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection