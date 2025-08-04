<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistem Kepegawaian</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            body { 
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen lg:flex">
            {{-- Kolom Kiri (Form) --}}
            <div class="flex flex-col justify-center items-center w-full lg:w-1/2 bg-gray-900 text-white p-8">
                <div class="w-full max-w-md">
                    {{-- Logo --}}
                    <div class="text-center mb-10">
                        <a href="/" class="inline-flex items-center gap-3">
                            <div class="bg-indigo-600 p-2 rounded-lg">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <span class="text-xl font-bold">Kepegawaian</span>
                        </a>
                    </div>
                    {{-- Di sinilah form login/register akan muncul --}}
                    {{ $slot }}
                </div>
            </div>

            {{-- Kolom Kanan (Ilustrasi) --}}
            <div class="hidden lg:flex flex-col justify-center items-center w-1/2 bg-gradient-to-tr from-blue-500 to-indigo-600 p-12 text-white">
                 <div class="text-left max-w-lg">
                    <h1 class="text-4xl font-bold leading-tight mb-4">Selamat Datang di Portal Pegawai</h1>
                    <p class="text-lg opacity-90">Masuk untuk mengakses akun Anda dan kelola data pegawai secara efisien.</p>
                    {{-- [PERBAIKAN] Mengganti URL gambar dengan yang baru dan lebih andal --}}
                    <img src="https://i.pinimg.com/736x/7c/60/05/7c6005347a471c2b237ecb28181084fb.jpg" alt="Ilustrasi Kantor Modern" class="mt-8 mx-auto rounded-lg shadow-2xl object-cover h-80 w-full" onerror="this.style.display='none'">
                 </div>
            </div>
        </div>
    </body>
</html>