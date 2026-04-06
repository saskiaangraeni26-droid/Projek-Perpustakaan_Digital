@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Data Petugas</h1>

<div class="bg-white p-6 rounded-xl shadow">

<table class="w-full border">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3">No</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Email</th>
        </tr>
    </thead>

    <tbody>
        @foreach($petugas as $p)
        <tr class="text-center border-t">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $p->name }}</td>
            <td class="p-3">{{ $p->email }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection