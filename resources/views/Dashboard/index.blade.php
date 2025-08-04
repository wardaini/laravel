@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h2>
    <p class="text-gray-400 mb-8">Ini adalah ringkasan data kepegawaian di perusahaan Anda saat ini.</p>

    {{-- KARTU RINGKASAN DATA UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Kartu Total Karyawan --}}
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 rounded-xl shadow-lg flex items-center space-x-4
        transform hover:-translate-y-2 transition-transform duration-300">
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-users fa-2x text-white"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-100 uppercase">Total Karyawan</p>
                <p class="text-3xl font-bold text-white">{{ $totalKaryawan ?? 0 }}</p>
            </div>
        </div>

        {{-- Kartu Total Jabatan --}}
        <div class="bg-gradient-to-br from-purple-500 to-violet-600 p-6 rounded-xl shadow-lg flex items-center space-x-4
        transform hover:-translate-y-2 transition-transform duration-300">
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-briefcase fa-2x text-white"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-purple-100 uppercase">Total Jabatan</p>
                <p class="text-3xl font-bold text-white">{{ $totalJabatan ?? 0 }}</p>
            </div>
        </div>

        {{-- Kartu Total Golongan --}}
        <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6 rounded-xl shadow-lg flex items-center space-x-4
        transform hover:-translate-y-2 transition-transform duration-300">
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-layer-group fa-2x text-white"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-orange-100 uppercase">Total Golongan</p>
                <p class="text-3xl font-bold text-white">{{ $totalGolongan ?? 0 }}</p>
            </div>
        </div>

    </div>

    {{-- MENU AKSES CEPAT --}}
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <h3 class="text-xl font-bold text-white mb-4">Akses Cepat</h3>
        {{-- PERBAIKAN: Mengubah lg:grid-cols-5 menjadi lg:grid-cols-4 --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">

            {{-- Kartu Akses Cepat Karyawan --}}
            <a href="{{ route('karyawan.index') }}" class="bg-blue-500 bg-opacity-20 border-2 border-blue-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-users fa-2x text-blue-300 group-hover:text-white transition-colors"></i>
                <p class="text-base font-medium text-white ml-4">Karyawan</p>
            </a>
            {{-- Kartu Akses Cepat Jabatan --}}
            <a href="{{ route('jabatan.index') }}" class="bg-purple-500 bg-opacity-20 border-2 border-purple-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-briefcase fa-2x text-purple-300 group-hover:text-white transition-colors"></i>
                <p class="text-base font-medium text-white ml-4">Jabatan</p>
            </a>
            {{-- Kartu Akses Cepat Golongan --}}
            <a href="{{ route('golongan.index') }}" class="bg-orange-500 bg-opacity-20 border-2 border-orange-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-layer-group fa-2x text-orange-300 group-hover:text-white transition-colors"></i>
                <p class="text-base font-medium text-white ml-4">Golongan</p>
            </a>
            {{-- Kartu Akses Cepat Cuti --}}
            <a href="{{ route('cuti.index') }}" class="bg-teal-500 bg-opacity-20 border-2 border-teal-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-calendar-alt fa-2x text-teal-300 group-hover:text-white transition-colors"></i>
                <p class="text-base font-medium text-white ml-4">Cuti</p>
            </a>
            {{-- Kartu Akses Cepat Gaji --}}
            <a href="{{ route('gaji.index') }}" class="bg-yellow-500 bg-opacity-20 border-2 border-yellow-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-money-bill-wave fa-2x text-yellow-300 group-hover:text-white transition-colors"></i>
                <p class="text-base font-medium text-white ml-4">Gaji</p>
            </a>
            {{-- Kartu Akses Cepat Lembur --}}
            <a href="{{ route('lembur.index') }}" class="bg-red-500 bg-opacity-20 border-2 border-purple-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-hourglass-half fa-2x text-purple-300 group-hover:text-white transition-colors"></i> {{-- Menggunakan ikon jam pasir untuk Lembur --}}
                <p class="text-base font-medium text-white ml-4">Lembur</p>
            </a>
            {{-- Kartu Akses Cepat Absensi --}}
            <a href="{{ route('absensi.index') }}" class="bg-blue-500 bg-opacity-20 border-2 border-blue-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-clock fa-2x text-blue-300 group-hover:text-white transition-colors"></i> {{-- Menggunakan ikon jam untuk Absensi --}}
                <p class="text-base font-medium text-white ml-4">Absensi</p>
            </a>
            {{-- Kartu Akses Cepat Pengumuman --}}
            <a href="{{ route('pengumuman.index') }}" class="bg-red-500 bg-opacity-20 border-2 border-red-500/40 hover:bg-opacity-100 hover:border-white p-6 rounded-lg flex flex-row items-center justify-start transform hover:-translate-y-1 transition-all duration-300 group">
                <i class="fas fa-bullhorn fa-2x text-red-300 group-hover:text-white transition-colors"></i> {{-- Ikon pengumuman --}}
                <p class="text-base font-medium text-white ml-4">Pengumuman</p>
            </a>


        </div>
    </div>

    <div class="text-center mt-12 text-sm text-gray-500">
        <p class="mb-1">Tim Pengembang - Kelompok 4 (A2)</p>
        <p class="font-semibold text-gray-400">Wardatul A'ani &bull; Latifatus Zahro &bull; Dinda</p>
    </div>
@endsection
