@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Pengembalian Buku</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <table class="w-full text-sm text-center border border-gray-200 rounded-lg overflow-hidden">
        
        {{-- HEADER --}}
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Cover</th>
                <th class="p-3">Judul Buku</th>
                <th class="p-3">Penulis</th>
                <th class="p-3">Jatuh Tempo</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody>
        @forelse($data as $pinjam)

            <tr class="border-t hover:bg-gray-50">

                {{-- COVER --}}
                <td class="p-3">
                    <img 
                        src="{{ optional($pinjam->buku)->cover ? asset('storage/' . $pinjam->buku->cover) : 'https://via.placeholder.com/80' }}"
                        class="w-14 h-20 object-cover rounded mx-auto">
                </td>

                {{-- JUDUL --}}
                <td class="p-3 font-medium">
                    {{ optional($pinjam->buku)->judul_buku ?? '-' }}
                </td>

                {{-- PENULIS --}}
                <td class="p-3 text-gray-600">
                    {{ optional($pinjam->buku)->penulis ?? '-' }}
                </td>

                {{-- JATUH TEMPO --}}
                <td class="p-3">
                    {{ $pinjam->tgl_kembali 
                        ? \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') 
                        : '-' }}
                </td>

                {{-- STATUS --}}
                <td class="p-3">
                    @if($pinjam->status == 'dipinjam')
                        <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-xs">
                            Dipinjam
                        </span>

                    @elseif($pinjam->status == 'menunggu_konfirmasi')
                        <span class="bg-purple-400 text-white px-3 py-1 rounded-full text-xs">
                            Menunggu Konfirmasi
                        </span>

                    @else
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                            Selesai
                        </span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td class="p-3">
                    @if($pinjam->status == 'dipinjam')

                        <a href="{{ route('anggota.form_kembali', $pinjam->id) }}"
                           class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                            Kembalikan
                        </a>

                    @elseif($pinjam->status == 'menunggu_konfirmasi')

                        <span class="text-purple-500 text-xs font-semibold">
                            Menunggu
                        </span>

                    @else

                        <span class="text-green-500 text-xs font-semibold">
                            ✔ Selesai
                        </span>

                    @endif
                </td>

            </tr>

        @empty
            <tr>
                <td colspan="6" class="p-6 text-gray-500">
                    Tidak ada buku yang harus dikembalikan
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

</div>

@endsection