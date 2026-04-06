@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-6">Data Anggota</h1>

    <div class="bg-white p-6 rounded-xl shadow">

        <!-- SEARCH -->
        <form method="GET" class="mb-4">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}" 
                placeholder="Cari nama atau email..."
                class="border p-2 rounded w-full"
            >
        </form>

        <!-- TABLE -->
        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr class="text-center">
                    <th class="p-2">No</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse($anggota as $index => $item)
                <tr class="text-center border-t">
                    <td class="p-2">
                        {{ $anggota->firstItem() + $index }}
                    </td>
                    <td class="p-2">{{ $item->name }}</td>
                    <td class="p-2">{{ $item->email }}</td>
                    <td class="p-2">{{ $item->role }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center">
                        Data kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $anggota->links() }}
        </div>

    </div>
</div>
@endsection