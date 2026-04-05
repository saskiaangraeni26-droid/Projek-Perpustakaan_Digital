<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Alpine -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- ✅ Fix biar modal ga glitch -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex overflow-visible">

    <!-- Sidebar -->
    <div class="w-64 bg-[#c86f6f] text-white p-6 fixed top-0 left-0 h-full overflow-y-auto z-40">

        <!-- FOTO -->
        <img 
            src="{{ asset('storage/sidebar/foto.png') }}" 
            class="h-20 mx-auto object-contain mb-4"
        >

        <!-- JUDUL -->
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

        <ul class="space-y-3">

            @if($role === 'petugas')

                <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                <li><a href="{{ route('buku.management') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Data Buku</a></li>
                <li><a href="{{ route('data_anggota.petugas') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Data Anggota</a></li>
                <li><a href="{{ route('petugas.peminjaman') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Data Peminjaman</a></li>
                <li><a href="{{ route('petugas.konfirmasi') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Data Pengembalian</a></li>

            @elseif($role === 'kepala')

                <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                <li><a href="/data-peminjaman" class="block hover:bg-[#a85a5a] p-2 rounded">Data Peminjaman</a></li>
                <li><a href="/data-pengembalian" class="block hover:bg-[#a85a5a] p-2 rounded">Data Pengembalian</a></li>
               <li>
            <a href="{{ route('kepala.laporan') }}" 
            class="block hover:bg-[#a85a5a] p-2 rounded">
                Laporan
            </a>
        </li>
            @elseif($role === 'anggota')

                <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                <li><a href="{{ route('buku.index') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Daftar Buku</a></li>
                <li><a href="{{ route('peminjaman.aktif') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Peminjaman</a></li>
                <li><a href="{{ route('pengembalian.buku') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Pengembalian</a></li>
                <li><a href="{{ route('peminjaman.riwayat') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Riwayat</a></li>

            @endif

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left hover:bg-[#a85a5a] p-2 rounded">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
        @endauth

    </div>

    <!-- Main -->
    <div class="ml-64 w-full overflow-visible">

        <!-- Navbar -->
        <div class="bg-white/80 backdrop-blur p-4 flex justify-between items-center shadow-sm fixed top-0 left-64 right-0 z-30">

            <h1 class="font-semibold text-gray-700 text-lg">
                Dashboard
            </h1>

            @auth
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <img 
                    src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" 
                    class="w-10 h-10 rounded-full border"
                >
            </div>
            @endauth

        </div>

        <!-- Content -->
        <div class="p-6 mt-20">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>