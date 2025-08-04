@extends('layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Edit Pengumuman</h2>

    <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" class="bg-gray-800 p-6 rounded-xl shadow-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-white mb-2">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
        </div>

        <div class="mb-4">
            <label class="block text-white mb-2">Isi Pengumuman</label>
            <textarea name="isi" rows="5" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
@endsection
