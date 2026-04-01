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
                    @if($item->status == 'dipinjam')
                        <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-xs">Dipinjam</span>
                    @else
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Dikembalikan</span>
                    @endif
                </td>
                <td>
                    @if($item->bayar_denda)
                        Rp {{ number_format($item->bayar_denda->jumlah,0,',','.') }}
                    @elseif($item->status == 'dikembalikan')
                        <span class="text-red-600 font-semibold">Belum Bayar</span>
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>
                    @if($item->status == 'dipinjam')
                    <form action="{{ route('peminjaman.kembali', $item->id) }}" method="POST" class="flex flex-col gap-2 items-center">
                        @csrf
                        <input type="number" name="denda" placeholder="Masukkan denda" class="border rounded px-2 py-1 w-24">
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Kembalikan & Bayar Denda</button>
                    </form>
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