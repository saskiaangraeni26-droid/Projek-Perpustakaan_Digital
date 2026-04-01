@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Management Buku</h1>

<div class="bg-white p-4 rounded-xl shadow">

    {{-- Tombol Tambah Buku --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('buku.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           + Tambah Buku
        </a>
    </div>

    {{-- Table --}}
    <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Judul Buku</th>
                <th class="p-2">Penulis</th>
                <th class="p-2">Status</th>
                <th class="p-2">Stok</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($buku as $item)
            <tr class="border-t">
                <td class="p-2">{{ $item->judul_buku }}</td>
                <td class="p-2">{{ $item->penulis }}</td>
                <td class="p-2">
                    @if($item->stok > 0)
                        <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">Tersedia</span>
                    @else
                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Tidak Tersedia</span>
                    @endif
                </td>
                <td class="p-2">{{ $item->stok }}</td>
                <td class="p-2 flex gap-2">

                    {{-- Tambah Stok --}}
                    <a href="{{ route('buku.tambah_stok', $item->id_buku) }}"
                       class="bg-blue-500 px-3 py-1 rounded text-white hover:bg-blue-600">
                       + Stok
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection