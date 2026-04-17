<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gradient-to-br from-red-200 via-dark red-300 to-pink-100 h-screen flex items-center justify-center">

<div class="flex bg-white rounded-3xl shadow-2xl overflow-hidden w-4/5 max-w-4xl">

    <!-- Left -->
    <div class="w-1/2 bg-gradient-to-br from-red-400 to-red-500 flex flex-col items-center justify-center relative p-6 text-white">
        <h1 class="text-5xl font-bold mb-4 animate-pulse">Selamat Datang!</h1>
        <p class="text-lg font-light text-white/80 text-center animate-fadeIn">
            Daftar sekarang dan mulai pengalaman baru <br> bersama aplikasi kami
        </p>
        <div class="absolute -bottom-16 -left-16 w-72 h-72 bg-white/20 rounded-full blur-3xl animate-spin-slow"></div>
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-2xl animate-spin-slow-reverse"></div>
    </div>

    <!-- Right -->
    <div class="w-1/2 p-12 flex flex-col justify-center relative">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Buat Akun Baru</h2>
        <p class="text-gray-500 mb-8">Isi data di bawah untuk mendaftar</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Nama -->
            <div class="relative">
                <i class="fa fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required
                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Email -->
            <div class="relative">
                <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- ✅ No HP -->
            <div class="relative">
                <i class="fa fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="no_hp" placeholder="No HP (08xxxx)" value="{{ old('no_hp') }}"
                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
            @error('no_hp')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Password -->
            <div class="relative">
                <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Confirm Password -->
            <div class="relative">
                <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition-all">
                Daftar
            </button>
        </form>

        <p class="mt-6 text-sm text-gray-500 text-center">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-red-500 font-medium hover:underline">Login</a>
        </p>
    </div>

</div>

<style>
@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 2s ease forwards; }
@keyframes spinSlow { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
.animate-spin-slow { animation: spinSlow 20s linear infinite; }
.animate-spin-slow-reverse { animation: spinSlow 25s linear infinite reverse; }
</style>

</body>
</html>