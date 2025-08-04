<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Kepegawaian') - Panel Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link.active { background-color: #4338ca; color: white; }
        .sidebar-link.active i, .sidebar-link:hover i { color: white; }
        *:focus, *:focus-visible { outline: none !important; box-shadow: none !important; }
    </style>
</head>
<body class="bg-gray-900">

    <div class="flex h-screen bg-gray-900">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-gray-300 flex flex-col shadow-lg">
            <div class="px-6 py-5 border-b border-gray-700 flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg"><i class="fas fa-building text-white"></i></div>
                <h2 class="text-xl font-bold text-white">Kepegawaian</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw mr-3 text-gray-400"></i>Dashboard
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-circle fa-fw mr-3 text-gray-400"></i>Profil Saya
                </a>

                @if (Auth::user()->role == 'admin')
                    <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase">Manajemen Data</p>
                    <a href="{{ route('golongan.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('golongan*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group fa-fw mr-3 text-gray-400"></i>Golongan
                    </a>
                    <a href="{{ route('jabatan.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('jabatan*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase fa-fw mr-3 text-gray-400"></i>Jabatan
                    </a>
                    <a href="{{ route('karyawan.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('karyawan*') ? 'active' : '' }}">
                        <i class="fas fa-users fa-fw mr-3 text-gray-400"></i>Karyawan
                    </a>
                    <a href="{{ route('absensi.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('absensi*') ? 'active' : '' }}">
                        <i class="fas fa-clock fa-fw mr-3 text-gray-400"></i>Absensi
                    </a>
                    <a href="{{ route('cuti.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('cuti*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt fa-fw mr-3 text-gray-400"></i>Cuti
                    </a>
                    <a href="{{ route('gaji.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('gaji*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave fa-fw mr-3 text-gray-400"></i>Gaji
                    </a>
                    <a href="{{ route('lembur.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('lembur*') ? 'active' : '' }}">
                        <i class="fas fa-clock fa-fw mr-3 text-gray-400"></i>Lembur
                    </a>
                    <a href="{{ route('pengumuman.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('pengumuman*') ? 'active' : '' }}">
                        <i class="fas fa-clock fa-fw mr-3 text-gray-400"></i>Pengumuman
                    </a>
                @else
                    <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase">Manajemen Data</p>
                    <a href="{{ route('absensi.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('absensi*') ? 'active' : '' }}">
                        <i class="fas fa-users fa-fw mr-3 text-gray-400"></i>Absen
                    </a>
                    <a href="{{ route('lembur.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('lembur*') ? 'active' : '' }}">
                        <i class="fas fa-clock fa-fw mr-3 text-gray-400"></i>Lembur
                    </a>
                    <a href="{{ route('pengumuman.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('pengumuman*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase fa-fw mr-3 text-gray-400"></i>Pengumuman
                    </a>
                    <a href="{{ route('cuti.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('cuti*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group fa-fw mr-3 text-gray-400"></i>Ajukan Cuti
                    </a>
                    <a href="{{ route('gaji.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->is('gaji*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave fa-fw mr-3 text-gray-400"></i>Riwayat Gaji anda
                    </a>
                @endif
            </nav>

            <div class="px-4 py-4 mt-auto border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-link flex items-center w-full px-4 py-2.5 rounded-lg text-red-400 hover:bg-red-500 hover:text-white transition-colors duration-200">
                        <i class="fas fa-sign-out-alt fa-fw mr-3"></i>Logout
                    </a>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-800 shadow-md border-b border-gray-700">
                <div class="flex items-center justify-between px-6 py-3">
                    <h1 class="text-lg font-semibold text-gray-200">@yield('title')</h1>
                    <div class="flex items-center">
                        <a href="{{ route('profile.edit') }}" class="mr-3 font-medium text-gray-300 hover:text-white">Halo, {{ Auth::user()->name }}</a>
                        <div class="h-10 w-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    @if (session('error'))
                        <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 p-4 rounded-lg mb-6" role="alert">
                            <p class="font-bold">Akses Ditolak!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
