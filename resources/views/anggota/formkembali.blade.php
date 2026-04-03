@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Form Pengembalian Buku</h1>

<div class="bg-white p-6 rounded-xl shadow w-1/2">

    <p><b>Judul:</b> {{ $pinjam->buku->judul_buku }}</p>
    <p><b>Nama:</b> {{ $pinjam->nama }}</p>
    <p><b>Batas Kembali:</b> {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') }}</p>

    <form action="{{ route('anggota.proses_kembali', $pinjam->id) }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="block text-sm">Catatan (opsional)</label>
            <textarea name="catatan" class="w-full border p-2 rounded"></textarea>
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Kirim Pengembalian
        </button>
    </form>

</div>

@endsection