@extends('layouts.app')

@section('title', 'Buat Pengumuman')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Buat Pengumuman Baru</h2>

    <form action="{{ route('pengumuman.store') }}" method="POST" class="bg-gray-800 p-6 rounded-xl shadow-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-white mb-2">Judul</label>
            <input type="text" name="judul" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
        </div>

        <div class="mb-4">
            <label class="block text-white mb-2">Isi Pengumuman</label>
            <textarea name="isi" rows="5" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required></textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
@endsection
