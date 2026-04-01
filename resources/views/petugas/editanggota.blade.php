<!-- resources/views/anggota/editanggota.blade.php -->
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Anggota</h1>

<div class="bg-white p-4 rounded-xl shadow">
    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" value="{{ $anggota->nama }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ $anggota->email }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border px-3 py-2 rounded">
                <option value="1" {{ $anggota->status == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $anggota->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan
        </button>
    </form>
</div>
@endsection