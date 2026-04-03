@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Form Pengembalian Buku</h2>

<div class="bg-white p-6 rounded shadow w-1/2">

    <p><b>Nama:</b> {{ $pinjam->nama }}</p>
    <p><b>Buku:</b> {{ $pinjam->buku->judul_buku }}</p>
    <p><b>Tanggal Pinjam:</b> {{ $pinjam->tgl_pinjam }}</p>

    <form action="{{ route('pengembalian.proses', $pinjam->id) }}" method="POST">
        @csrf

        <div class="mt-4">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tgl_pengembalian" 
                   class="border p-2 w-full" 
                   value="{{ date('Y-m-d') }}"
                   required>
        </div>

        <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

</div>

@endsection