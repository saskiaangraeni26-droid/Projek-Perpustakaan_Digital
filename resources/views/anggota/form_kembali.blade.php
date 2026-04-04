@extends('layouts.app')

@section('content')

<h1 class="text-xl mb-4">Form Pengembalian</h1>

<form action="{{ route('pengembalian.update', $pinjam->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Tanggal Dikembalikan</label>
    <input type="date" name="tgl_dikembalikan" class="border p-2 w-full mb-3" required>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
        Ajukan Pengembalian
    </button>
</form>

@endsection