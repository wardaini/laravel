<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Sistem Kepegawaian</title>
    {{-- Memuat Tailwind CSS & Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    {{-- Latar belakang menggunakan gambar orang kantor --}}
    <div class="relative min-h-screen  flex flex-col items-center justify-center p-4 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?q=80&w=2071&auto=format&fit=crop');">
        
        {{-- Overlay gelap agar tulisan lebih terbaca --}}
        <div class="absolute inset-0 bg-black opacity-50"></div>

        {{-- Kartu Utama dengan efek kaca --}}
        <div class="relative z-10 w-full max-w-lg text-center bg-white/10 backdrop-blur-lg p-8 sm:p-12 rounded-2xl shadow-2xl border border-white/20">
            {{-- Logo --}}
            <div class="bg-indigo-600 w-20 h-20 flex items-center justify-center rounded-2xl mb-6 mx-auto shadow-lg">
                <i class="fas fa-building text-4xl text-white"></i>
            </div>
            
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight">
                Sistem Informasi Kepegawaian
            </h1>
            <p class="mt-4 text-lg text-white opacity-80 max-w-md mx-auto">
                Platform terpadu untuk mengelola seluruh data dan aktivitas kepegawaian dengan lebih efisien.
            </p>

            {{-- Tombol Aksi --}}
            @if (Route::has('login'))
                <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto bg-white hover:bg-gray-200 text-gray-900 font-bold py-3 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                            Lanjutkan ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white hover:bg-gray-200 text-gray-900 font-bold py-3 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full sm:w-auto bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 hover:bg-white hover:text-gray-900">
                                Daftar Akun Baru
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        {{-- ======================================================= --}}
        {{-- NAMA KELOMPOK (BAGIAN BARU) --}}
        {{-- ======================================================= --}}
        <div class="relative z-10 text-center text-sm text-gray-200 mt-8">
            <p class="mb-1">Tim Pengembang - Kelompok 4 (A2)</p>
            <p class="font-semibold text-white">Wardatul A'ani &bull; Latifatus Zahro &bull; Dinda</p>
        </div>
    </div>
</body>
</html>
