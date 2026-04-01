<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-gray-200 h-screen flex items-center justify-center">

<div class="bg-white w-80 p-6 rounded-xl border border-gray-300 text-center">

    <h2 class="text-xl font-semibold mb-5">Login</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4" autocomplete="off">
        @csrf

        <!-- Username / Email -->
        <div class="relative">
            <i class="fa fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="email"
                name="email"
                placeholder="email"
                autocomplete="off"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>

        <!-- Password -->
        <div class="relative">
            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="new-password"
                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:outline-none">
        </div>

        <!-- Button -->
        <button
            type="submit"
            class="w-full py-2 rounded-lg bg-[#c86f6f] text-white hover:bg-[#a85a5a] transition">
            Login
        </button>
    </form>

    <!-- Register -->
    <p class="mt-4 text-sm text-gray-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[#c86f6f] font-medium hover:underline">
            Register
        </a>
    </p>

</div>

</body>
</html>