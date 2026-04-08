@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Peminjaman</h1>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-2xl shadow-md">

    <!-- 🔍 SEARCH FORM -->
    <form method="GET" class="mb-4 flex gap-2 items-center">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari nama anggota..."
            class="border p-2 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Cari
        </button>
    </form>

    <!-- 📊 TABLE -->
    <table class="w-full text-sm text-center border rounded-xl overflow-hidden">
        
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Cover</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Buku</th>
                <th class="p-3">Tanggal Pinjam</th>
                <th class="p-3">Tanggal Kembali</th>
                <th class="p-3">Status</th>
                <th class="p-3">Konfirmasi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)
        <tr class="border-t hover:bg-gray-50">

            <!-- COVER -->
            <td class="p-2">
                <img 
                    src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}" 
                    width="80" 
                    class="rounded mx-auto">
            </td>

            <!-- NAMA -->
            <td class="p-3">{{ $item->nama }}</td>

            <!-- BUKU -->
            <td class="p-3">
                {{ optional($item->buku)->judul_buku }}
            </td>

            <!-- TGL PINJAM -->
            <td class="p-3">
                {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
            </td>

            <!-- TGL KEMBALI -->
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
            <td class="p-3">
    @if($item->status == 'menunggu')
        <form action="{{ route('petugas.setujui', $item->id) }}" method="POST">
    @csrf
    @method('PUT')

    <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
        ✔
    </button>
</form>

    @elseif($item->status == 'dipinjam')
        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full">
            ✔
        </span>

    @elseif($item->status == 'selesai')
        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full">
            ✓
        </span>

    @else
        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-400 text-white rounded-full">
            -
        </span>
    @endif
</td>

        </tr>

        @empty
        <tr>
            <td colspan="7" class="p-4 text-gray-500">
                Tidak ada data
            </td>
        </tr>
        @endforelse
        </tbody>

    </table>
    <div class="mt-4">
    {{ $data->links() }}
</div>
</div>

@endsection