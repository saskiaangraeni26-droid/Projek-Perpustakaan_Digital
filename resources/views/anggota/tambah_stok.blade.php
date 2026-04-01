@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Stok: {{ $buku->judul_buku }}</h1>

<form action="{{ route('buku.updateStok', $buku->id_buku) }}" method="POST" class="bg-white p-4 rounded shadow w-1/3">
    @csrf
    <label class="block mb-2">Jumlah Stok</label>
    <input type="number" name="stok" class="border p-2 w-full mb-4" min="1" value="1" required>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Tambah Stok
    </button>
</form>
@endsection