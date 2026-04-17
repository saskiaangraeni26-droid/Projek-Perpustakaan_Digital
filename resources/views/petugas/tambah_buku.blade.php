@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Tambah Buku</h1>

<div class="bg-white p-6 rounded-xl shadow w-full max-w-lg">

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul --}}
        <input type="text" name="judul_buku" placeholder="Judul Buku"
            class="border p-2 w-full mb-2 rounded" required>
        @error('judul_buku')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        {{-- Penulis --}}
        <input type="text" name="penulis" placeholder="Penulis"
            class="border p-2 w-full mb-2 rounded" required>

        {{-- Tahun Terbit (FIX) --}}
        <input type="number" name="tahun_terbit" placeholder="Tahun Terbit"
            class="border p-2 w-full mb-2 rounded" required>

        {{-- KATEGORI --}}
        <select name="category_id" class="border p-2 w-full mb-2 rounded">
            <option value="">Pilih Kategori</option>

            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">
                    {{ $cat->nama_kategori }}
                </option>
            @endforeach
        </select>

        {{-- Cover --}}
        <input type="file" name="cover" id="coverInput"
            class="border p-2 w-full mb-2 rounded" accept="image/*">

        {{-- Preview --}}
        <img id="preview" src="https://via.placeholder.com/150"
            class="w-32 h-48 object-cover rounded mb-2">

        {{-- Stok --}}
        <input type="number" name="stok" placeholder="Stok"
            class="border p-2 w-full mb-2 rounded" min="0" required>

        <div class="flex justify-between mt-4">
            <a href="{{ route('buku.management') }}"
                class="bg-gray-400 text-white px-4 py-2 rounded">
                Kembali
            </a>

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>
</div>

{{-- Preview JS --}}
<script>
document.getElementById('coverInput').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
}
</script>

@endsection