@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pengumuman
        </a>
    </div>

    {{-- Kartu Konten Pengumuman --}}
    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        {{-- Header Kartu --}}
        <div class="p-8 border-b border-gray-700">
            <h1 class="text-3xl font-bold text-white leading-tight">{{ $pengumuman->judul }}</h1>
            <div class="flex items-center text-sm text-gray-400 mt-3">
                <div class="flex items-center mr-6">
                    <i class="fas fa-calendar-alt fa-fw mr-2"></i>
                    <span>Diterbitkan pada: {{ $pengumuman->created_at->translatedFormat('l, j F Y') }}</span>
                </div>
                {{-- Anda bisa menambahkan penulis jika ada relasinya, contoh: --}}
                {{-- 
                @if($pengumuman->user)
                <div class="flex items-center">
                    <i class="fas fa-user fa-fw mr-2"></i>
                    <span>Oleh: {{ $pengumuman->user->name }}</span>
                </div>
                @endif
                --}}
            </div>
        </div>

        {{-- Isi Konten Pengumuman --}}
        <div class="p-8">
            {{-- Class 'prose' dari Tailwind akan otomatis memformat paragraf, daftar, dll. --}}
            <div class="prose prose-invert max-w-none text-gray-300">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>
        </div>
    </div>
@endsection
