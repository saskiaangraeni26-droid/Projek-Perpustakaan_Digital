@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h1 class="text-2xl font-semibold">Dashboard</h1>
    <h3 class="text-gray-600 text-sm">
        Hallo, Selamat Datang
    </h3>
</div>

<!-- 🔥 NOTIFIKASI -->
@if($terlambat > 0)
<div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
    ⚠ Kamu punya {{ $terlambat }} buku yang terlambat!
</div>
@endif

@if($jatuhTempo->count() > 0)
<div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-4">
    ⏳ Ada buku yang akan jatuh tempo dalam 3 hari!
</div>
@endif

<!-- 🔥 Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <!-- Total Buku -->
    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
        <div>
            <h3 class="text-gray-500 text-sm">Total Buku</h3>
            <p class="text-xl font-bold text-[#c86f6f]">
                {{ $totalBuku }}
            </p>
        </div>
    </div>

    <!-- Sedang Dipinjam -->
    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
        <div>
            <h3 class="text-gray-500 text-sm">Sedang Dipinjam</h3>
            <p class="text-xl font-bold text-[#c86f6f]">
                {{ $dipinjam }}
            </p>
        </div>
    </div>

    <!-- Terlambat -->
    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
        <div>
            <h3 class="text-gray-500 text-sm">Terlambat</h3>
            <p class="text-xl font-bold text-[#c86f6f]">
                {{ $terlambat }}
            </p>
        </div>
    </div>

    <!-- Denda -->
    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" class="w-10">
    <div>
        <h3 class="text-gray-500 text-sm">Total Denda</h3>

        @if($denda > 0)
            <p class="text-xl font-bold text-red-500">
                Rp {{ number_format($denda, 0, ',', '.') }}
            </p>
        @else
            <p class="text-xl font-bold text-green-500">
                Rp 0
            </p>
        @endif

    </div>
</div>

</div>

<!-- 📚 PEMINJAMAN TERAKHIR -->
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <h3 class="font-semibold mb-3">Peminjaman Terakhir</h3>

    <table class="w-full text-sm text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Buku</th>
                <th class="p-2">Tgl Pinjam</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($peminjamanTerakhir as $item)
            <tr class="border-t">
                <td>{{ optional($item->buku)->judul_buku ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                <td>
                    @if($item->status == 'dipinjam')
                        <span class="text-yellow-500 font-semibold">Dipinjam</span>
                    @elseif($item->status == 'menunggu')
                        <span class="text-blue-500 font-semibold">Menunggu</span>
                    @elseif($item->status == 'menunggu_konfirmasi')
                        <span class="text-purple-500 font-semibold">Menunggu Konfirmasi</span>
                    @else
                        <span class="text-green-500 font-semibold">Selesai</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="p-3 text-gray-400">Belum ada data</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- ⏳ JATUH TEMPO -->
<div class="bg-white p-4 rounded-xl shadow">
    <h3 class="font-semibold mb-3">Segera Dikembalikan</h3>

    <ul class="space-y-2">
        @forelse($jatuhTempo as $item)
            <li class="flex justify-between bg-gray-50 p-2 rounded">
                <span>{{ optional($item->buku)->judul_buku ?? '-' }}</span>
                <span class="text-red-500 text-sm font-semibold">
                    {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}
                </span>
            </li>
        @empty
            <p class="text-gray-400 text-sm">Tidak ada</p>
        @endforelse
    </ul>
</div>

@endsection