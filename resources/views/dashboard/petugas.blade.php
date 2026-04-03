@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h1 class="text-2xl font-semibold">Dashboard Petugas</h1>
    <h3 class="text-gray-600 text-sm">Hallo, Selamat Datang</h3>
</div>

<!-- Statistik -->
<div class="grid grid-cols-3 gap-4 mb-6">

    <!-- Total Buku -->
<div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
    <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
    <div>
        <h3 class="text-gray-500 text-sm">Total Buku</h3>
        <p class="text-xl font-bold text-[#c86f6f]">{{ $totalBuku }}</p> <!-- sesuai controller -->
    </div>
</div>

<!-- Total Dipinjam -->
<div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
    <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
    <div>
        <h3 class="text-gray-500 text-sm">Total Dipinjam</h3>
        <p class="text-xl font-bold text-[#c86f6f]">{{ $totalDipinjam }}</p> <!-- sesuai controller -->
    </div>
</div>

<!-- Total Dikembalikan -->
<div class="bg-white p-4 rounded-xl shadow flex items-center space-x-3">
    <img src="https://i.pinimg.com/736x/3b/a6/cf/3ba6cf6d58f2ece99447bb3335d25a0e.jpg" class="w-10">
    <div>
        <h3 class="text-gray-500 text-sm">Total Dikembalikan</h3>
        <p class="text-xl font-bold text-[#c86f6f]">{{ $totalDikembalikan }}</p> <!-- sesuai controller -->
    </div>
</div>
    <!-- Bisa ditambahkan statistik lain, misal Total Anggota atau Buku Tersedia -->
</div>

@endsection