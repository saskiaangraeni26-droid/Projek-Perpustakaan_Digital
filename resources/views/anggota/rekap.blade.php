@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Rekap Data Peminjaman</h1>

<div class="bg-white p-6 rounded-2xl shadow-md">

    <table class="w-full text-sm text-center border rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Cover</th>
                <th class="p-3">Judul Buku</th>
                <th class="p-3">Tanggal Pinjam</th>
                <th class="p-3">Jatuh Tempo</th>
                <th class="p-3">Dikembalikan</th>
                <th class="p-3">Denda</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
            <tr>

                {{-- COVER --}}
                <td class="p-3">
                    <img src="{{ $item->buku && $item->buku->cover 
                        ? asset('storage/' . $item->buku->cover) 
                        : 'https://via.placeholder.com/150' }}"
                        class="rounded-lg w-20 h-28 object-cover mx-auto">
                </td>

                {{-- JUDUL --}}
                <td class="p-3">
                    {{ optional($item->buku)->judul_buku ?? 'Buku tidak ditemukan' }}
                </td>

                {{-- TGL PINJAM --}}
                <td class="p-3">
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}
                </td>

                {{-- JATUH TEMPO --}}
                <td class="p-3">
                    {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}
                </td>

                {{-- DIKEMBALIKAN --}}
                <td class="p-3">
                    {{ $item->tgl_dikembalikan 
                        ? \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('d F Y') 
                        : '-' }}
                </td>

                {{-- ✅ DENDA --}}
                <td class="p-3">
                    @if($item->denda > 0)
                        <span class="text-red-500 font-semibold">
                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                        </span>
                    @else
                        <span class="text-green-500">0</span>
                    @endif
                </td>

                {{-- STATUS --}}
                <td class="p-3">
                    @if($item->status == 'dipinjam')
                        <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-xs">
                            Dipinjam
                        </span>
                    @elseif($item->status == 'menunggu')
                        <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-xs">
                            Menunggu
                        </span>
                    @elseif($item->status == 'menunggu_konfirmasi')
                        <span class="bg-purple-400 text-white px-3 py-1 rounded-full text-xs">
                            Menunggu Konfirmasi
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
                <td colspan="7" class="p-4 text-gray-500">
                    Belum ada riwayat
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
    {{ $data->links() }}
</div>
</div>

@endsection