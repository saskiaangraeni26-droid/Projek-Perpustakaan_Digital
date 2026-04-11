@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Tambah Petugas</h1>

<div class="bg-white p-6 rounded-xl shadow">

<form action="{{ route('kepala.store') }}" method="POST">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
    </div>
     @error('email')
    <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <div class="mb-4">
        <label class="block mb-1">Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded" required>
    </div>

   <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan
        </button>
    </div>

</form>

</div>

@endsection