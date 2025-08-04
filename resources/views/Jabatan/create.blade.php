@extends('layouts.app')

@section('title', 'Tambah Jabatan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Tambah Jabatan Baru</h1>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <form action="{{ route('jabatan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_jabatan" class="block text-sm font-medium text-gray-400 mb-1">Nama Jabatan</label>
                <input type="text" name="nama_jabatan" id="nama_jabatan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" required>
            </div>
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-400 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500"></textarea>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('jabatan.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </form>
    </div>
@endsection
