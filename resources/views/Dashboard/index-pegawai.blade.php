@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Judul Selamat Datang --}}
    <h2 class="text-3xl font-bold text-white mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>

    {{-- Informasi Pegawai --}}
    <div class="bg-gray-800 rounded-xl shadow-lg p-6 flex items-center space-x-6 mb-8">
        <img src="{{ $karyawanDataLogin?->foto_profil ? asset('storage/' . $karyawanDataLogin->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=A78BFA&background=1F2937' }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500">
        <div>
            <h3 class="text-xl font-semibold text-indigo-300">{{ $karyawanDataLogin?->nama ?? Auth::user()->name }}</h3>
            <p class="font-bold text-gray-200">{{ $karyawanDataLogin?->jabatan?->nama_jabatan ?? 'Jabatan Belum Diatur' }}</p>
            @if ($karyawanDataLogin?->nip)
                <p class="text-sm text-gray-100 mt-1">NIP: {{ $karyawanDataLogin->nip }}</p>
            @endif
        </div>
    </div>

    {{-- Kartu Data & Aksi Cepat --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        {{-- KARTU 1: Sisa Cuti --}}
        <div class="bg-gradient-to-br from-cyan-500 to-blue-500 p-6 rounded-xl shadow-lg flex flex-col items-center justify-center text-center transform hover:-translate-y-2 transition-transform duration-300">
            <p class="text-sm font-medium text-cyan-100 uppercase tracking-wider">Sisa Cuti Tahunan</p>
            <p class="text-6xl font-extrabold text-white my-2">{{ $sisaCuti ?? 0 }}</p>
            <p class="text-gray-200">Hari</p>
        </div>

        {{-- KARTU 2: Tombol Absen (Logika Clock-In/Clock-Out) --}}
        <div class="bg-purple-600 p-6 rounded-xl shadow-lg flex flex-col items-center justify-center text-center transform hover:-translate-y-2 transition-transform duration-300">
            <p class="text-sm font-medium text-purple-100 uppercase tracking-wider">Absen Hari Ini</p>

            @if ($karyawanDataLogin)
                @if (!$absensiHariIni)
                    {{-- Kondisi 1: Belum absen sama sekali --}}
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $karyawanDataLogin->id }}">
                        <button type="submit" class="bg-white text-purple-700 font-bold py-3 px-6 rounded-lg mt-4">Absen Masuk</button>
                    </form>
                @elseif ($absensiHariIni && !$absensiHariIni->waktu_keluar)
                    {{-- Kondisi 2: Sudah absen masuk, belum pulang --}}
                    <form action="{{ route('absensi.update', $absensiHariIni->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-white text-purple-700 font-bold py-3 px-6 rounded-lg mt-4">Absen Pulang</button>
                    </form>
                    <p class="text-xs text-purple-100 mt-2">Sudah masuk: {{ \Carbon\Carbon::parse($absensiHariIni->waktu_masuk)->format('H:i') }}</p>
                @else
                    {{-- Kondisi 3: Sudah absen masuk & pulang --}}
                    <p class="text-white font-semibold mt-4">Absensi selesai.</p>
                    <p class="text-xs text-purple-100">Masuk: {{ \Carbon\Carbon::parse($absensiHariIni->waktu_masuk)->format('H:i') ?? '-' }} | Keluar: {{ $absensiHariIni->waktu_keluar ? \Carbon\Carbon::parse($absensiHariIni->waktu_keluar)->format('H:i') : '-' }}</p>
                @endif
            @else
                 <p class="text-yellow-300 text-sm mt-4">Lengkapi profil untuk absen.</p>
            @endif
        </div>

        {{-- KARTU 3: Tombol Lembur --}}
        <div class="bg-green-600 p-6 rounded-xl shadow-lg flex flex-col items-center justify-center text-center transform hover:-translate-y-2 transition-transform duration-300">
            <p class="text-sm font-medium text-green-100 uppercase tracking-wider">Ajukan Lembur</p>
            <a href="{{ route('lembur.create') }}" class="bg-white text-green-700 font-bold py-3 px-6 rounded-lg mt-4">Ajukan</a>
        </div>

        {{-- KARTU 4: Tombol Pengumuman --}}
        <div class="bg-{{ $unreadPengumuman > 0 ? 'red-600' : 'blue-600' }} p-6 rounded-xl shadow-lg flex flex-col items-center justify-center text-center transform hover:-translate-y-2 transition-transform duration-300">
            <p class="text-sm font-medium text-white uppercase tracking-wider">Pengumuman</p>
            <a href="{{ route('pengumuman.index') }}" class="bg-white text-black font-bold py-3 px-6 rounded-lg mt-4 relative">
                Lihat Pengumuman
                @if($unreadPengumuman > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2 py-1">{{ $unreadPengumuman }}</span>
                @endif
            </a>
        </div>

    </div>

    {{-- Tombol Aksi Lain --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <a href="{{ route('cuti.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-lg transition-colors text-center text-lg">
            <i class="fas fa-calendar-plus mr-2"></i> Ajukan Cuti
        </a>
        <a href="{{ route('gaji.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition-colors text-center text-lg">
            <i class="fas fa-file-invoice-dollar mr-2"></i> Lihat Riwayat Gaji Anda
        </a>
    </div>

    {{-- Bagian Absensi Terakhir --}}
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
        <h3 class="text-xl font-bold text-white mb-4">5 Absensi Terakhir Anda</h3>
        @if($absensis->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensis as $absen)
                            <tr class="border-b border-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">{{ \Carbon\Carbon::parse($absen->tanggal_absensi)->format('d M Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ ucwords($absen->status_kehadiran) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $absen->waktu_keluar ? \Carbon\Carbon::parse($absen->waktu_keluar)->format('H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada data absensi terbaru.</p>
        @endif
        <div class="mt-4 text-right">
            <a href="{{ route('absensi.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm">Lihat Semua Absensi</a>
        </div>
    </div>


    <div class="text-center mt-12 text-sm text-gray-500">
        <p class="mb-1">Tim Pengembang - Kelompok 4 (A2)</p>
        <p class="font-semibold text-gray-400">Wardatul A'ani &bull; Latifatus Zahro &bull; Dinda</p>
    </div>

@endsection
