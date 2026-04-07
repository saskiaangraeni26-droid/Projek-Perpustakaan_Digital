@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard Petugas</h1>
    <p class="text-gray-500 text-sm">Pantau aktivitas perpustakaan hari ini</p>
</div>

<!-- 🔥 STATISTIK UTAMA -->
<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Total Buku</p>
        <h2 class="text-2xl font-bold text-[#c86f6f]">{{ $totalBuku }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Total Dipinjam</p>
        <h2 class="text-2xl font-bold text-[#c86f6f]">{{ $totalDipinjam }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Sudah Kembali</p>
        <h2 class="text-2xl font-bold text-[#c86f6f]">{{ $totalDikembalikan }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Terlambat</p>
        <h2 class="text-2xl font-bold text-red-500">{{ $terlambat }}</h2>
    </div>

</div>

<!-- 🔥 AKTIVITAS HARI INI -->
<div class="grid grid-cols-2 gap-4 mb-6">

    <div class="bg-blue-500 text-white p-4 rounded-xl shadow">
        <p class="text-sm">Peminjaman Hari Ini</p>
        <h2 class="text-2xl font-bold">{{ $peminjamanHariIni }}</h2>
    </div>

    <div class="bg-green-500 text-white p-4 rounded-xl shadow">
        <p class="text-sm">Pengembalian Hari Ini</p>
        <h2 class="text-2xl font-bold">{{ $pengembalianHariIni }}</h2>
    </div>

</div>

<!-- 🔥 ALERT -->
@if($menunggu > 0)
<div class="bg-yellow-100 text-yellow-700 p-3 rounded mb-4">
    ⚠️ {{ $menunggu }} peminjaman menunggu persetujuan!
</div>
@endif

@if($terlambat > 0)
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    🚨 Ada {{ $terlambat }} buku terlambat dikembalikan!
</div>
@endif

<!-- 🔥 DATA TERBARU -->
<div class="bg-white p-4 rounded-xl shadow">

    <h2 class="text-lg font-semibold mb-3">Peminjaman Terbaru</h2>

    <table class="w-full text-sm text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Nama</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Status</th>
                <th class="p-2">Tanggal</th>
            </tr>
        </thead>

        <tbody>
        @forelse($terbaru as $item)
            <tr class="border-t">
                <td class="p-2">{{ $item->nama }}</td>
                <td class="p-2">{{ optional($item->buku)->judul_buku }}</td>
                <td class="p-2">
                    @if($item->status == 'menunggu')
                        <span class="text-blue-500">Menunggu</span>
                    @elseif($item->status == 'dipinjam')
                        <span class="text-yellow-500">Dipinjam</span>
                    @else
                        <span class="text-green-500">Selesai</span>
                    @endif
                </td>
                <td class="p-2">
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-3 text-gray-400">
                    Belum ada data
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection