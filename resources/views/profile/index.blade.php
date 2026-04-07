@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Profile</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}"
                class="w-full border p-2 rounded">
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update Profile
        </button>
    </form>

</div>

@endsection