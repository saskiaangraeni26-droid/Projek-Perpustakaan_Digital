<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-[#c86f6f] text-white p-6">
        <h2 class="text-xl font-semibold mb-6"> Perpustakaan</h2>

        @auth
            @php $role = trim(auth()->user()->role); @endphp

            <ul class="space-y-3">

                <!-- Sidebar Petugas -->
                @if($role === 'petugas')
                    <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                   <li>
                        <a href="{{ route('buku.management') }}" class="block hover:bg-[#a85a5a] p-2 rounded">
                            Data Buku
                        </a>
                    </li>
                   <li>
                    <a href="{{ route('data_anggota.petugas') }}" 
                    class="block hover:bg-[#a85a5a] p-2 rounded">
                        Data Anggota
                    </a>
                    </li>
                    <a href="{{ route('petugas.peminjaman') }}" 
                    class="block hover:bg-[#a85a5a] p-2 rounded">
                        Data Peminjaman
                    </a>
                    <li><a href="/management-pengembalian" class="block hover:bg-[#a85a5a] p-2 rounded">Data Pengembalian</a></li>
                    <li><a href="/management-denda" class="block hover:bg-[#a85a5a] p-2 rounded">Data Denda</a></li>
                    <li><a href="/laporan" class="block hover:bg-[#a85a5a] p-2 rounded">Laporan</a></li>

                <!-- Sidebar Kepala -->
                @elseif($role === 'kepala')
                    <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                    <li><a href="/data-peminjaman" class="block hover:bg-[#a85a5a] p-2 rounded">Data Peminjaman</a></li>
                    <li><a href="/data-pengembalian" class="block hover:bg-[#a85a5a] p-2 rounded">Data Pengembalian</a></li>
                    <li><a href="/data-denda" class="block hover:bg-[#a85a5a] p-2 rounded">Data Denda</a></li>

                <!-- Sidebar Anggota -->
                @elseif($role === 'anggota')
                    <li><a href="/dashboard" class="block hover:bg-[#a85a5a] p-2 rounded">Dashboard</a></li>
                    <li><a href="{{ route('buku.index') }}" class="block hover:bg-[#a85a5a] p-2 rounded">Daftar Buku</a></li>
                <li>
                    <a href="{{ route('peminjaman.riwayat') }}"         
                    class="block hover:bg-[#a85a5a] p-2 rounded">
                    Peminjaman
                    </a>
                </li>
                @endif

                <!-- Logout -->
                <li>    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left hover:bg-[#a85a5a] p-2 rounded">Logout</button>
                    </form>
                </li>
            </ul>
        @endauth
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <div class="bg-white p-4 flex justify-between items-center shadow-sm">
            <div></div> <!-- Placeholder kiri jika mau menu tambahan -->
            @auth
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->role }}</p>
                    </div>
                    <img 
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" 
                        class="w-10 h-10 rounded-full border"
                    >
                </div>
            @endauth
        </div>

        <!-- Konten Dashboard -->
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>