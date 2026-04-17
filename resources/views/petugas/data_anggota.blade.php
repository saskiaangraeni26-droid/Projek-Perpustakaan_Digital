@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-semibold">Data Anggota</h1>
    <p class="text-gray-500 text-sm">Daftar semua anggota perpustakaan</p>
</div>

<div class="bg-white p-6 rounded-xl shadow">

    <!-- 🔍 SEARCH + BUTTON -->
    <div class="flex justify-between items-center mb-4">
        
        <form method="GET" class="flex gap-2">
            <input 
                type="text" 
                name="search"
                placeholder="Cari nama / email..."
                class="border px-3 py-2 rounded w-64"
                value="{{ request('search') }}"
            >
            <button class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cari
            </button>
        </form>

        <a href="{{ url('/tambah-anggota') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           + Tambah Anggota
        </a>

    </div>

    <!-- 📊 INFO -->
    <div class="mb-3 text-sm text-gray-500">
        Total Anggota: <span class="font-semibold text-black">{{ $anggota->count() }}</span>
    </div>

    <!-- 📋 TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center border border-gray-200 rounded-lg overflow-hidden">
            
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">No HP</th> {{-- ✅ ganti --}}
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($anggota as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>

                    <td class="p-3 font-medium">
                        {{ $item->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $item->email }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $item->no_hp ?? '-' }} {{-- ✅ tampil no hp --}}
                    </td>

                    <td class="p-3 text-center">
                        <a href="{{ route('anggota.show', $item->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
                           Detail
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="p-4 text-gray-500">
                        Tidak ada data anggota 😢
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection