@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4 text-center">LAPORAN PENGEMBALIAN BUKU</h2>

{{-- 🔍 FILTER + PDF --}}
<div class="bg-white p-4 rounded-xl shadow mb-4">
    <form method="GET" class="flex flex-wrap gap-3 items-end">

        <div>
            <label class="text-sm">Dari</label>
            <input type="date" name="dari" value="{{ request('dari') }}"
                class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="text-sm">Sampai</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                class="border p-2 rounded w-full">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Filter
            </button>

            <a href="{{ route('kepala.laporanpengembalian') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>

            {{-- 📄 PDF --}}
            <a href="{{ route('kepala.laporanpengembalian.pdf', request()->all()) }}"
            target="_blank"
            class="bg-red-500 text-white px-4 py-2 rounded">
            Cetak PDF
            </a>
        </div>

    </form>
</div>

{{-- 📊 TABLE --}}
<div class="bg-white p-4 rounded-xl shadow">

<table class="w-full text-sm text-center border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border">No</th>
            <th class="p-2 border">Judul Buku</th>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Tanggal Pinjam</th>
            <th class="p-2 border">Jatuh Tempo</th>
            <th class="p-2 border">Tanggal Kembali</th>
            <th class="p-2 border">Terlambat</th>
            <th class="p-2 border">Denda</th>
        </tr>
    </thead>
    <tbody>

    @php $no = 1; $totalDenda = 0; @endphp

    @forelse($data as $item)
        @php
            $tglPinjam = \Carbon\Carbon::parse($item->tgl_pinjam);
            $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
            $dikembalikan = \Carbon\Carbon::parse($item->tgl_dikembalikan);

            $terlambat = $dikembalikan->gt($jatuhTempo) 
                ? $jatuhTempo->diffInDays($dikembalikan) 
                : 0;

            $denda = $terlambat * 5000;
            $totalDenda += $denda;
        @endphp

        <tr>
            <td class="border p-2">{{ $no++ }}</td>
            <td class="border">{{ optional($item->buku)->judul_buku ?? '-' }}</td>
            <td class="border">{{ $item->nama }}</td>
            <td class="border">{{ $tglPinjam->format('d M Y') }}</td>
            <td class="border">{{ $jatuhTempo->format('d M Y') }}</td>
            <td class="border">{{ $dikembalikan->format('d M Y') }}</td>
            <td class="border">{{ $terlambat }} hari</td>
            <td class="border text-red-500 font-semibold">
                Rp {{ number_format($denda, 0, ',', '.') }}
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="8" class="p-4">Tidak ada data</td>
        </tr>
    @endforelse

    </tbody>

    {{-- TOTAL --}}
    <tfoot>
        <tr class="bg-gray-100 font-bold">
            <td colspan="7" class="text-right p-2 border">Total Denda</td>
            <td class="border text-red-600">
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $data->withQueryString()->links() }}
</div>

</div>

@endsection