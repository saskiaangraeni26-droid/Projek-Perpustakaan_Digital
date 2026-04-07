@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Konfirmasi & Riwayat Pengembalian</h1>

<div class="bg-white p-6 rounded-xl shadow">

    {{-- SEARCH --}}
    <form method="GET" class="mb-4 flex gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="border p-2 rounded w-64">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Cari
        </button>
    </form>

    <table class="w-full text-sm text-center border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Cover</th>
                <th class="p-2">Judul Buku</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Jatuh Tempo</th>
                <th class="p-2">Dikembalikan</th>
                <th class="p-2">Denda</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $item)

            @php
                $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
                $dikembalikan = $item->tgl_dikembalikan 
                    ? \Carbon\Carbon::parse($item->tgl_dikembalikan) 
                    : now();

                $terlambat = $dikembalikan->gt($jatuhTempo) ? $jatuhTempo->diffInDays($dikembalikan) : 0;
                $denda = $terlambat * 5000;
            @endphp

            <tr class="{{ $item->status == 'dikembalikan' ? 'bg-green-50' : 'bg-yellow-50' }}">

                {{-- COVER --}}
                <td class="p-2">
                    <img src="{{ optional($item->buku)->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80' }}"
                         width="60"
                         class="rounded mx-auto">
                </td>

                {{-- BUKU --}}
                <td>{{ optional($item->buku)->judul_buku ?? '-' }}</td>

                {{-- NAMA --}}
                <td>{{ $item->nama }}</td>

                {{-- JATUH TEMPO --}}
                <td>{{ $jatuhTempo->format('d M Y') }}</td>

                {{-- DIKEMBALIKAN --}}
                <td>
                    {{ $item->tgl_dikembalikan ? $dikembalikan->format('d M Y') : '-' }}
                </td>

                {{-- DENDA --}}
                <td>
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
                        <span class="text-green-500 font-semibold">✔</span>
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

    <div class="mt-4">
    {{ $data->links() }}
</div>

</div>
@endsection