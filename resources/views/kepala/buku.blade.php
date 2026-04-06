@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Data Buku</h1>

<div class="bg-white p-4 rounded-xl shadow">

    <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Cover</th>
                <th class="p-2">Judul Buku</th>
                <th class="p-2">Penulis</th>
                <th class="p-2">Status</th>
                <th class="p-2">Stok</th>
            </tr>
        </thead>

        <tbody>
            @foreach($buku as $item)
            <tr class="border-t">

                <td class="p-2">
                    @if($item->cover)
                        <img src="{{ asset('storage/' . $item->cover) }}" width="80" class="rounded">
                    @else
                        <img src="https://via.placeholder.com/80" class="rounded">
                    @endif
                </td>

                <td class="p-2">{{ $item->judul_buku }}</td>
                <td class="p-2">{{ $item->penulis }}</td>

                <td class="p-2">
                    @if($item->stok > 0)
                        <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">Tersedia</span>
                    @else
                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Tidak Tersedia</span>
                    @endif
                </td>

                <td class="p-2">{{ $item->stok }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection