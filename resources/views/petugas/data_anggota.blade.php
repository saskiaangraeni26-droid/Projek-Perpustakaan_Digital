@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Data Anggota</h1>

<div class="bg-white p-4 rounded-xl shadow">

    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-4">
        <a href="{{ url('/tambah-anggota') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           + Tambah Anggota
        </a>
    </div>

    <!-- Table -->
    <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Nama</th>
                <th class="p-2">Email</th>
                <th class="p-2">Status</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($anggota as $a)
            <tr class="border-t">
                <td class="p-2">{{ $a->nama }}</td>
                <td class="p-2">{{ $a->email }}</td>

                <td class="p-2">
                    @if($a->status == 1)
                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded">
                            Aktif
                        </span>
                    @else
                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded">
                            Tidak Aktif
                        </span>
                    @endif
                </td>

                <td class="p-2 flex gap-2">
    <a href="{{ route('anggota.edit', $a->id) }}" 
       class="bg-purple-500 px-3 py-1 rounded text-white">
       Edit
    </a>
    <form action="{{ route('anggota.destroy', $a->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="bg-red-500 px-3 py-1 rounded text-white"
                onclick="return confirm('Yakin ingin menghapus anggota ini?')">
            Hapus
        </button>
    </form>
</td>
</form>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection