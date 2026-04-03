@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Rekap Data Peminjaman</h1>

<div class="bg-white p-6 rounded-2xl shadow-md">

    <table class="w-full text-sm text-center border rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Judul Buku</th>
                <th class="p-3">Tanggal Pinjam</th>
                <th class="p-3">Tanggal Kembali</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
            <tr class="border-t hover:bg-gray-50">

                <!-- Judul -->
                <td class="p-3">
                   {{ optional($item->buku)->judul_buku ?? 'Buku tidak ditemukan' }}
                </td>

                <!-- Tgl Pinjam -->
                <td class="p-3">
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}
                </td>

                <!-- Tgl Kembali -->
                <td class="p-3">
                    {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}
                </td>

                <!-- ✅ STATUS (FIX) -->
                <td class="p-3">
                    @if($item->status == 'dipinjam')
                        <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-xs">
                            Dipinjam
                        </span>
                    @elseif($item->status == 'menunggu')
                        <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-xs">
                            Menunggu
                        </span>
                    @else
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                            Selesai
                        </span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-gray-500">
                    Belum ada riwayat
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection