@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Konfirmasi Pengembalian Buku</h1>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-xl shadow">
    <table class="w-full text-sm text-center">
        
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Cover</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Tgl Pinjam</th>
                <th class="p-2">Jatuh Tempo</th>
                <th class="p-2">Dikembalikan</th>
                <th class="p-2">Denda</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)
            <tr class="border-t">

                {{-- COVER --}}
                <td class="p-2">
                    <img 
                        src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}"
                        width="60"
                        class="rounded mx-auto">
                </td>

                <td>{{ optional($item->buku)->judul_buku ?? '-' }}</td>

                <td>{{ $item->nama }}</td>

                {{-- TGL PINJAM --}}
                <td>
                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                </td>

                {{-- JATUH TEMPO (BALIKIN NORMAL) --}}
                <td>
                    {{ $item->tgl_kembali 
                        ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') 
                        : '-' }}
                </td>

                {{-- TGL DIKEMBALIKAN --}}
                <td>
                    {{ $item->tgl_dikembalikan 
                        ? \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('d M Y') 
                        : '-' }}
                </td>

                {{-- DENDA (PINDAH KE SINI) --}}
                <td>
                    @php
                        $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
                        $dikembalikan = $item->tgl_dikembalikan 
                            ? \Carbon\Carbon::parse($item->tgl_dikembalikan) 
                            : null;

                        $denda = 0;

                        if ($dikembalikan && $dikembalikan->gt($jatuhTempo)) {
                            $terlambat = $jatuhTempo->diffInDays($dikembalikan);
                            $denda = $terlambat * 1000;
                        }
                    @endphp

                    @if($denda > 0)
                        <span class="text-red-500 font-semibold">
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </span>
                    @else
                        <span class="text-green-500">0</span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td>
                    @if($item->status == 'menunggu_konfirmasi')
                    <form action="{{ route('petugas.konfirmasi.kembali', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            Konfirmasi
                        </button>
                    </form>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-4 text-gray-500">
                    Tidak ada data
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>
@endsection