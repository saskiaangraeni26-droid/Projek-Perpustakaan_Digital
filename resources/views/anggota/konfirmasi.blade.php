@extends('layouts.app')

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Konfirmasi Peminjaman Buku</h1>
    </div>

    <div class="grid grid-cols-2 gap-6">

        <!-- 📚 CARD BUKU -->
        <div class="bg-white p-4 rounded-xl shadow">
            <div class="flex flex-col items-center">
                    

                <h3 class="mt-3 font-semibold text-lg text-center">
                    {{ $buku->judul_buku }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $buku->penulis }}
                </p>

                <p class="text-xs text-gray-400">
                    Tahun: {{ $buku->tahun_terbit }}
                </p>

                <span class="mt-2 px-3 py-1 text-xs bg-indigo-500 text-white rounded-lg">
                    {{ $buku->stok }} Tersedia
                </span>

                <button class="mt-3 bg-rose-400 text-white px-4 py-2 rounded-lg text-sm">
                    Stok Tersedia
                </button>
            </div>

            <!-- INFO -->
            <div class="mt-1 text-xs text-gray-600">
                <p>Lama Pinjam: 7 Hari</p>
                <p>Batas Pengembalian: {{ now()->addDays(7)->format('d M Y') }}</p>
                <p>Denda: Rp.5000 / hari</p>
            </div>
        </div>

        <!-- 📝 FORM -->
        <div class="bg-white p-6 rounded-xl shadow">

            <h2 class="font-semibold mb-4">Formulir Peminjaman</h2>

            <form action="{{ route('anggota.pinjam', $buku->id_buku) }}" method="POST">
                @csrf

                <div class="space-y-3">

                    <input type="text" name="nama" placeholder="Nama"
                        class="w-full border p-2 rounded-lg">

                    <input type="text" name="nis" placeholder="NIS"
                        class="w-full border p-2 rounded-lg">

                    <input type="text" name="telepon" placeholder="No Telepon"
                        class="w-full border p-2 rounded-lg">

                    <input type="date" name="tgl_pinjam"
                        class="w-full border p-2 rounded-lg">

                    <input type="date" name="tgl_kembali"
                        class="w-full border p-2 rounded-lg">

                    <textarea name="catatan" placeholder="Catatan (opsional)"
                        class="w-full border p-2 rounded-lg"></textarea>

                </div>

                <!-- BUTTON -->
                <div class="flex justify-between mt-6">

                    <a href="{{ route('buku.index') }}"
                       class="px-5 py-2 border rounded-lg">
                       ⬅️ Kembali
                    </a>

                    <button class="bg-rose-400 text-white px-6 py-2 rounded-lg hover:bg-rose-500">
                        ✔ Pinjam Buku
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection