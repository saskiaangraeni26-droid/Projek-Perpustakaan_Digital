@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Tambah Petugas</h2>

<form method="POST" action="{{ route('petugas.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="w-full border p-2">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2">
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2">
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection