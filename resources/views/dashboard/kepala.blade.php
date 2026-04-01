@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Dashboard Kepala</h1>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <div>
            <h3 class="text-gray-500 text-sm">Total Buku</h3>
            <p class="text-xl font-bold">{{ $stats['totalBuku'] }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <div>
            <h3 class="text-gray-500 text-sm">Total Anggota</h3>
            <p class="text-xl font-bold">{{ $stats['totalAnggota'] }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
        <div>
            <h3 class="text-gray-500 text-sm">Total Petugas</h3>
            <p class="text-xl font-bold">{{ $stats['totalPetugas'] }}</p>
        </div>
    </div>
</div>
@endsection