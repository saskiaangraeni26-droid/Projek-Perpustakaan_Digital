@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Peminjaman</h1>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-200 text-red-800 p-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<div class="bg-white p-6 rounded-2xl shadow-md">

    <!-- SEARCH FORM -->
    <form method="GET" class="mb-4 flex gap-2 items-center">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari nama anggota..."
            class="border p-2 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Cari
        </button>
    </form>

    <!-- TABLE -->
    <table class="w-full text-sm text-center border rounded-xl overflow-hidden">
        
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Cover</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Buku</th>
                <th class="p-3">Tanggal Pinjam</th>
                <th class="p-3">Tanggal Kembali</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)
        <tr class="border-t hover:bg-gray-50 transition">

            <!-- COVER -->
            <td class="p-2">
                <img 
                    src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}" 
                    width="70" 
                    class="rounded mx-auto shadow-sm">
            </td>

            <!-- NAMA -->
            <td class="p-3 font-medium">{{ $item->nama }}</td>

            <!-- BUKU -->
            <td class="p-3">
                {{ $item->buku->judul_buku ?? $item->judul_buku ?? '-' }}
            </td>

            <!-- TGL PINJAM -->
            <td class="p-3">
                {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
            </td>

            <!-- TGL KEMBALI -->
            <td class="p-3">
                {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}
            </td>

            <!-- STATUS / AKSI -->
            <td class="p-3">
                
                {{-- ================= MENUNGGU ================= --}}
                @if($item->status == 'menunggu')

                    @if($item->buku)
                    <div class="flex justify-center gap-2">

                        <!-- KONFIRMASI -->
                        <form action="{{ route('petugas.setujui', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button 
                                class="flex items-center gap-1 bg-green-500 text-white px-3 py-1.5 rounded-lg shadow-sm hover:bg-green-600 transition">
                                <span>Konfirmasi</span>
                            </button>
                        </form>

                        <!-- TOLAK -->
                        <form action="{{ route('petugas.tolak', $item->id) }}" method="POST">
                            @csrf

                            <button 
                                onclick="return confirm('Yakin ingin menolak peminjaman ini?')"
                                class="flex items-center gap-1 bg-red-500 text-white px-3 py-1.5 rounded-lg shadow-sm hover:bg-red-600 transition">
                                <span>Tolak</span>
                            </button>
                        </form>

                    </div>
                    @else
                        {{-- 🔥 BUKU SUDAH DIHAPUS --}}
                        <div class="flex flex-col items-center gap-1">
                            <span class="px-3 py-1 bg-gray-400 text-white rounded-full text-xs">
                                Tidak tersedia
                            </span>
                            <span class="text-xs text-red-500 italic">
                                Buku sudah dihapus
                            </span>
                        </div>
                    @endif

                {{-- ================= DIPINJAM ================= --}}
                @elseif($item->status == 'dipinjam')
                    <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-xs">
                        Dipinjam
                    </span>

                {{-- ================= MENUNGGU PENGEMBALIAN ================= --}}
                @elseif($item->status == 'menunggu_konfirmasi')
                    <span class="px-3 py-1 bg-purple-500 text-white rounded-full text-xs">
                        Menunggu Pengembalian
                    </span>

                {{-- ================= DITOLAK ================= --}}
                @elseif($item->status == 'ditolak')
                    <div class="flex flex-col items-center gap-1">
                        <!-- <span class="px-3 py-1 bg-red-500 text-white rounded-full text-xs">
                            Ditolak
                        </span> -->

                        <!-- @if($item->alasan)
                        <span class="text-xs text-gray-500 italic">
                            "{{ $item->alasan }}"
                        </span>
                        @endif
                    </div> -->

                {{-- ================= SELESAI ================= --}}
                @elseif($item->status == 'selesai' || $item->status == 'dikembalikan')
                    <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-xs">
                        Selesai
                    </span>

                @endif

            </td>

        </tr>

        @empty
        <tr>
            <td colspan="6" class="p-4 text-gray-500">
                Tidak ada data
            </td>
        </tr>
        @endforelse
        </tbody>

    </table>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection