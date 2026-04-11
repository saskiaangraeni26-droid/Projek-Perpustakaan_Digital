@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">Data Petugas</h1>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    {{-- 🔍 SEARCH --}}
    <form method="GET" class="w-full md:w-1/2">
    <div class="relative">
        
        {{-- ICON --}}
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
            🔍
        </span>

        {{-- INPUT --}}
        <input 
            type="text" 
            name="search" 
            value="{{ $search ?? '' }}" 
            placeholder="Cari nama atau email..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 
                   transition"
        >
    </div>
</form>

    {{-- ➕ TAMBAH --}}
    <div class="text-right">
        <a href="{{ route('kepala.tambahpetugas') }}"
           class="bg-green-500 text-white px-5 py-3 rounded-lg shadow hover:bg-green-600 transition whitespace-nowrap">
           + Tambah Petugas
        </a>
    </div>

</div>

{{-- 📦 CARD --}}
<div class="bg-white p-6 rounded-2xl shadow-lg">

{{-- ✅ ALERT --}}
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 p-3 mb-4 rounded-lg">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded-lg">
    {{ session('error') }}
</div>
@endif

{{-- 📊 TABLE --}}
<div class="overflow-x-auto">
<table class="w-full border border-gray-200 rounded-lg overflow-hidden">

    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="p-3">No</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
    @forelse($petugas as $p)
    <tr class="text-center border-t hover:bg-gray-50 transition">
        <td class="p-3">{{ $loop->iteration }}</td>
        <td class="p-3 text-left font-medium">{{ $p->name }}</td>
        <td class="p-3 text-left text-gray-600">{{ $p->email }}</td>

        <td class="p-3">
            <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="p-4 text-gray-500 text-center">
            Data petugas belum ada 😢
        </td>
    </tr>
    @endforelse
    </tbody>

</table>
</div>

</div>

@endsection