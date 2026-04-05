@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Peminjaman</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <table class="w-full text-sm text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Cover</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Tgl Pinjam</th>
                <th class="p-2">Jatuh Tempo</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)
            <tr class="border-t">

                <td class="p-2">
                    <img 
                        src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}"
                        width="60"
                        class="rounded mx-auto">
                </td>

                <td>{{ optional($item->buku)->judul_buku ?? '-' }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}
                </td>

                <td>
                    @if($item->status == 'menunggu')
                        <span class="bg-blue-400 text-white px-2 py-1 rounded text-xs">
                            Menunggu
                        </span>
                    @elseif($item->status == 'dipinjam')
                        <span class="bg-yellow-400 text-white px-2 py-1 rounded text-xs">
                            Dipinjam
                        </span>
                    @elseif($item->status == 'menunggu_konfirmasi')
                        <span class="bg-purple-400 text-white px-2 py-1 rounded text-xs">
                            Menunggu Konfirmasi
                        </span>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-4 text-gray-500">
                    Tidak ada peminjaman aktif
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

</div>

@endsection