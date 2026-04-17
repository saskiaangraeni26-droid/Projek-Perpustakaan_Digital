@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold">
                {{ strtoupper(substr($anggota->name, 0, 1)) }}
            </div>
            <h1 class="text-xl font-semibold mt-3">Detail Anggota</h1>
            <p class="text-gray-400 text-sm">Informasi lengkap anggota</p>
        </div>

        <!-- Info -->
        <div class="space-y-4 text-sm">

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Nama</span>
                <span class="font-medium">{{ $anggota->name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Email</span>
                <span class="font-medium">{{ $anggota->email }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">No HP</span>
                <span class="font-medium">
                    {{ $anggota->no_hp ? $anggota->no_hp : 'Belum diisi' }}
                </span>
            </div>

        </div>

        <!-- Tombol -->
        <div class="mt-6 flex justify-between">

            <a href="{{ route('data_anggota.petugas') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm">
               Kembali
            </a>

        </div>

    </div>

</div>

@endsection