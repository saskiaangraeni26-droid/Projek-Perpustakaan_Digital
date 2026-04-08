@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-md">

    <!-- Judul -->
    <h2 class="text-xl font-bold text-center mb-4">
        LAPORAN PEMINJAMAN BUKU
    </h2>

    <!-- FILTER -->
    <div class="bg-gray-50 p-4 rounded-xl shadow-sm mb-4">
        <form method="GET" class="flex items-end gap-4 flex-wrap">

            <div>
                <label class="block text-sm text-gray-600 mb-1">Dari</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                    class="border px-3 py-2 rounded-lg w-44">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Sampai</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                    class="border px-3 py-2 rounded-lg w-44">
            </div>

            <div class="flex gap-2">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Filter
                </button>

                <a href="{{ route('kepala.laporanpeminjaman') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Reset
                </a>

                <a href="{{ route('kepala.laporanpeminjaman.pdf', request()->query()) }}"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Cetak PDF
                </a>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Judul Buku</th>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Tanggal Pinjam</th>
                    <th class="p-2 border">Jatuh Tempo</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1; @endphp

                @forelse($data as $item)
                    @php
                        $tglPinjam = \Carbon\Carbon::parse($item->tgl_pinjam);
                        $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
                    @endphp

                    <tr class="hover:bg-gray-50">
                        <td class="border p-2">{{ $no++ }}</td>
                        <td class="border p-2">
                            {{ optional($item->buku)->judul_buku ?? '-' }}
                        </td>
                        <td class="border p-2">{{ $item->nama }}</td>
                        <td class="border p-2">{{ $tglPinjam->format('d M Y') }}</td>
                        <td class="border p-2">{{ $jatuhTempo->format('d M Y') }}</td>

                        <!-- STATUS -->
                        <td class="border p-2">
                            @if($item->tgl_dikembalikan)
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                    Dikembalikan
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                    Dipinjam
                                </span>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection