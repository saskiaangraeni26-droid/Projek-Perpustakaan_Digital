@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white p-8 rounded-2xl shadow-lg">

        <!-- HEADER -->
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-blue-100 p-3 rounded-full">
                👤
            </div>
            <div>
                <h2 class="text-xl font-bold">Profile</h2>
                <p class="text-sm text-gray-500">Kelola informasi akun kamu</p>
            </div>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf

           <!-- Nama -->
            <div>
                <label class="block text-sm mb-1 text-gray-600">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm mb-1 text-gray-600">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- No HP -->
            <div>
                <label class="block text-sm mb-1 text-gray-600">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                    placeholder="Contoh: 08123456789"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                @error('no_hp')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- BUTTON -->
            <button 
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 shadow-md">
                💾 Update Profile
            </button>
        </form>

    </div>
</div>

@endsection