@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Petugas</h1>

<div class="flex justify-end mb-4">
    <a href="{{ route('kepala.tambahpetugas') }}"
       class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
       + Tambah Petugas
    </a>
</div>

<div class="bg-white p-6 rounded-xl shadow">

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-200 text-red-800 p-3 mb-4 rounded">
    {{ session('error') }}
</div>
@endif

<table class="w-full border">
   <tr>
    <th class="p-3">No</th>
    <th class="p-3">Nama</th>
    <th class="p-3">Email</th>
    <th class="p-3">Aksi</th>
    </tr>

   @foreach($petugas as $p)
<tr class="text-center border-t">
    <td class="p-3">{{ $loop->iteration }}</td>
    <td class="p-3">{{ $p->name }}</td>
    <td class="p-3">{{ $p->email }}</td>

    <td class="p-3">
        <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
            @csrf
            @method('DELETE')

            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach

</table>

</div>

@endsection