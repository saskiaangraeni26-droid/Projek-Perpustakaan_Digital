@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Kepala</h1>
    <p class="text-gray-500 text-sm">Monitoring aktivitas perpustakaan</p>
</div>

<!-- 🔥 SUMMARY -->
<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Total Buku</p>
        <h2 class="text-3xl font-bold text-[#c86f6f]">{{ $stats['totalBuku'] }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Anggota</p>
        <h2 class="text-3xl font-bold text-blue-500">{{ $stats['totalAnggota'] }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Petugas</p>
        <h2 class="text-3xl font-bold text-green-500">{{ $stats['totalPetugas'] }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Peminjaman</p>
        <h2 class="text-3xl font-bold text-purple-500">{{ $stats['totalPeminjaman'] }}</h2>
    </div>

</div>

<!-- 🔥 PROGRESS TERLAMBAT -->
<div class="bg-white p-5 rounded-2xl shadow mb-6">

    <div class="flex justify-between mb-2">
        <p class="text-gray-600">Keterlambatan Pengembalian</p>
        <p class="font-semibold text-red-500">
            {{ $stats['peminjamanTerlambat'] }} kasus
        </p>
    </div>

    @php
        $persen = $stats['totalPeminjaman'] > 0 
            ? ($stats['peminjamanTerlambat'] / $stats['totalPeminjaman']) * 100 
            : 0;
    @endphp

    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-red-500 h-3 rounded-full"
             style="width: {{ $persen }}%">
        </div>
    </div>

    <p class="text-xs text-gray-400 mt-2">
        {{ number_format($persen, 1) }}% dari total peminjaman
    </p>

</div>

<!-- 🔥 AKTIVITAS HARI INI -->
<div class="grid grid-cols-2 gap-4 mb-6">

    <div class="bg-blue-500 text-white p-5 rounded-2xl shadow">
        <p class="text-sm opacity-80">Peminjaman Hari Ini</p>
        <h2 class="text-3xl font-bold">{{ $stats['peminjamanHariIni'] }}</h2>
    </div>

    <div class="bg-green-500 text-white p-5 rounded-2xl shadow">
        <p class="text-sm opacity-80">Pengembalian Hari Ini</p>
        <h2 class="text-3xl font-bold">{{ $stats['pengembalianHariIni'] }}</h2>
    </div>

</div>

<!-- 🔥 RECENT ACTIVITY -->
<div class="bg-white p-5 rounded-2xl shadow mb-6">

    <h2 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h2>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Nama</th>
                <th class="p-2 text-left">Buku</th>
                <th class="p-2 text-left">Tanggal</th>
                <th class="p-2 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recent as $item)
            <tr class="border-t">
                <td class="p-2">{{ optional($item->user)->name }}</td>
                <td class="p-2">{{ optional($item->buku)->judul_buku }}</td>
                <td class="p-2">
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                </td>
                <td class="p-2">
                    @if($item->status == 'dipinjam')
                        <span class="text-yellow-500">Dipinjam</span>
                    @elseif($item->status == 'dikembalikan')
                        <span class="text-green-500">Selesai</span>
                    @else
                        <span class="text-blue-500">{{ $item->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center p-3 text-gray-400">
                    Belum ada aktivitas
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<!-- 🔥 ALERT -->
@if($stats['peminjamanTerlambat'] > 0)
<div class="bg-red-100 text-red-700 p-3 rounded">
    ⚠️ Ada keterlambatan, segera lakukan pengecekan!
</div>
@endif

@endsection