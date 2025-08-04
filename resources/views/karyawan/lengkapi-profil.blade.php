@extends('layouts.app')

@section('title', 'Lengkapi Profil Kepegawaian')

@section('content')
<div class="flex items-center justify-center py-12">
    <div class="w-full max-w-2xl px-6 py-8 bg-gray-800 rounded-xl shadow-lg">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-white mb-2">Lengkapi Profil Anda</h1>
            <p class="text-gray-300 mb-6">Sebagai pegawai baru, harap isi data personal Anda di bawah ini untuk melanjutkan.</p>
        </div>

        @if(session('warning'))
            <div class="bg-yellow-900 bg-opacity-50 border border-yellow-700 text-yellow-300 p-4 rounded-lg mb-6 text-sm" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-white">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->name) }}" required autofocus
                       class="mt-1 block w-full bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 {{ $errors->has('nama_lengkap') ? 'border-red-500' : 'border-gray-600' }}">
                @error('nama_lengkap')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-white">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                       class="mt-1 block w-full bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('tanggal_lahir') border-red-500 @else border-gray-600 @enderror" style="color-scheme: dark;">
                @error('tanggal_lahir')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="alamat" class="block text-sm font-medium text-white">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="3" required
                          class="mt-1 block w-full bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-600' }}">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="no_hp" class="block text-sm font-medium text-white">Nomor HP</label>
                <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required
                       class="mt-1 block w-full bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 border-gray-600">
                @error('no_hp')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Simpan dan Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection