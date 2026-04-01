<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-gray-200 h-screen flex items-center justify-center">

<div class="bg-white w-80 p-6 rounded-xl border border-gray-300 text-center">

    <h2 class="text-xl font-semibold mb-5">Register</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="relative">
            <i class="fa fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="text"
                name="name"
                placeholder="Name"
                value="{{ old('name') }}"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>
        @error('name')
            <p class="text-red-500 text-sm text-left">{{ $message }}</p>
        @enderror

        <!-- Email -->
        <div class="relative">
            <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>
        @error('email')
            <p class="text-red-500 text-sm text-left">{{ $message }}</p>
        @enderror

        <!-- Password -->
        <div class="relative">
            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>
        @error('password')
            <p class="text-red-500 text-sm text-left">{{ $message }}</p>
        @enderror

        <!-- Confirm Password -->
        <div class="relative">
            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>

        <!-- Button -->
        <button
            type="submit"
            class="w-full py-2 rounded-lg bg-[#c86f6f] text-white hover:bg-[#a85a5a] transition">
            Register
        </button>

    </form>

    <!-- Login link -->
    <p class="mt-4 text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-[#c86f6f] font-medium hover:underline">
            Login
        </a>
    </p>

</div>

</body>
</html>