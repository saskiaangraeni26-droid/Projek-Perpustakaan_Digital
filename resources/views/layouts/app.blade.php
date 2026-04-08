<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perpustakaan</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#c86f6f] text-white p-6 fixed top-0 left-0 h-full overflow-y-auto z-40">

        <!-- Logo -->
        <img 
            src="{{ asset('storage/sidebar/foto.png') }}" 
            class="h-20 mx-auto object-contain mb-4"
        >

        <!-- Title -->
        <h2 class="text-xl font-semibold mb-6 text-center">
            <span class="text-red-400">P</span>
            <span class="text-orange-400">e</span>
            <span class="text-yellow-400">r</span>
            <span class="text-green-400">p</span>
            <span class="text-blue-400">u</span>
            <span class="text-indigo-400">s</span>
            <span class="text-purple-400">t</span>
            <span class="text-pink-400">a</span>
            <span class="text-red-400">k</span>
            <span class="text-orange-400">a</span>
            <span class="text-yellow-400">a</span>
            <span class="text-green-400">n</span>
        </h2>

        @auth
        @php $role = trim(auth()->user()->role); @endphp

        <ul class="space-y-2 text-sm">

            @if($role === 'petugas')
                <li><a href="/dashboard" class="block p-2 rounded hover:bg-[#a85a5a] transition">Dashboard</a></li>
                <li><a href="{{ route('buku.management') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Buku</a></li>
                <li><a href="{{ route('data_anggota.petugas') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Anggota</a></li>
                <li><a href="{{ route('petugas.peminjaman') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Peminjaman</a></li>
                <li><a href="{{ route('petugas.konfirmasi') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Pengembalian</a></li>

            @elseif($role === 'kepala')
                <li><a href="/dashboard" class="block p-2 rounded hover:bg-[#a85a5a] transition">Dashboard</a></li>
                <li><a href="{{ route('kepala.buku') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Buku</a></li>
                <li><a href="{{ route('kepala.anggota') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Anggota</a></li>
                <li><a href="{{ route('kepala.petugas') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Data Petugas</a></li>
                <li><a href="{{ route('kepala.laporanpeminjaman') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Laporan Peminjaman</a></li>
                <li><a href="{{ route('kepala.laporanpengembalian') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Laporan Pengembalian</a></li>

            @elseif($role === 'anggota')
                <li><a href="/dashboard" class="block p-2 rounded hover:bg-[#a85a5a] transition">Dashboard</a></li>
                <li><a href="{{ route('buku.index') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Daftar Buku</a></li>
                <li><a href="{{ route('peminjaman.aktif') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Peminjaman</a></li>
                <li><a href="{{ route('pengembalian.buku') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Pengembalian</a></li>
                <li><a href="{{ route('peminjaman.riwayat') }}" class="block p-2 rounded hover:bg-[#a85a5a] transition">Riwayat</a></li>
            @endif

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left p-2 rounded hover:bg-[#a85a5a] transition">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
        @endauth

    </aside>

    <!-- MAIN -->
    <main class="ml-64 w-full">

        <!-- NAVBAR -->
        <nav class="bg-white/80 backdrop-blur p-4 flex justify-between items-center shadow fixed top-0 left-64 right-0 z-30">

            <h1 class="font-semibold text-gray-700 text-lg">
            </h1>

            @auth
            <div class="flex items-center space-x-3 relative" x-data="{ open: false }">

                <!-- Info User -->
                <div @click="open = !open" class="text-right cursor-pointer">
                    <p class="font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>

                <!-- Avatar -->
                <img 
                    @click="open = !open"
                    src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" 
                    class="w-10 h-10 rounded-full border cursor-pointer"
                >

                <!-- Dropdown -->
                <div 
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    x-cloak
                    class="absolute right-0 top-14 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                >

                    <a href="{{ route('profile') }}" 
                       class="block px-4 py-2 hover:bg-gray-100">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>

                </div>

            </div>
            @endauth

        </nav>

        <!-- CONTENT -->
        <section class="p-6 mt-20">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>