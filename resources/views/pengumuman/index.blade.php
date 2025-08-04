@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
    <a href="{{ route('dashboard') }}" class="text-indigo-400 hover:text-indigo-600 flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
    </a>
    <h2 class="text-3xl font-bold text-white mb-6">Pengumuman</h2>
    <p class="text-gray-400 mb-6">Jangan lewatkan setiap pengumuman baru!!!</p>

    {{-- Tombol Tambah hanya untuk Admin --}}
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('pengumuman.create') }}" class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            <i class="fas fa-plus"></i> Tambah Pengumuman
        </a>
    @endif

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        @forelse ($pengumuman as $item)
            <div class="mb-4 p-4 bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg text-white font-bold">{{ $item->judul }}</h3>
                        <p class="text-gray-300 text-sm">{{ $item->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('pengumuman.show', $item->id) }}" class="text-indigo-400 hover:text-indigo-200">Baca</a>

                        {{-- Tombol Edit & Hapus hanya untuk Admin --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('pengumuman.edit', $item->id) }}" class="text-yellow-400 hover:text-yellow-200">
                                Edit
                            </a>

                            <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-300">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400">Tidak ada pengumuman.</p>
        @endforelse
    </div>
@endsection
