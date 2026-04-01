@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h1 class="text-2xl font-semibold">Dashboard</h1>
    <h3 class="text-gray-600 text-sm">
        Hallo, Selamat Datang
    </h3>
</div>

<!-- 🔥 Statistik -->
<div class="grid grid-cols-3 gap-4 mb-6">

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

</div>

@endsection