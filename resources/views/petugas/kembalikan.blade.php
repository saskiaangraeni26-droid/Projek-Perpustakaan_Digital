@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Form Pengembalian</h1>

<div class="bg-white p-6 rounded-xl shadow w-1/2">

    <p><b>Nama:</b> {{ $pinjam->nama }}</p>
    <p><b>Buku:</b> {{ $pinjam->buku->judul_buku }}</p>
    <p><b>Tanggal Kembali:</b> 
        {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') }}
    </p>

    @php
        $today = \Carbon\Carbon::now();
        $tglKembali = \Carbon\Carbon::parse($pinjam->tgl_kembali);

        $terlambat = $today->greaterThan($tglKembali)
            ? $tglKembali->diffInDays($today)
            : 0;

        $denda = $terlambat * 1000;
    @endphp

    <p class="mt-2">
        <b>Keterlambatan:</b> {{ $terlambat }} hari
    </p>

    <p class="mb-4">
        <b>Denda:</b> 
        <span class="text-red-500 font-semibold">
            Rp {{ number_format($denda) }}
        </span>
    </p>

    <form action="{{ route('petugas.proses_kembali', $pinjam->id) }}" method="POST">
        @csrf

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Simpan Pengembalian
        </button>
    </form>

</div>

@endsection