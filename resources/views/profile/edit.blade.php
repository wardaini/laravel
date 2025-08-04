@extends('layouts.app')

@section('title', 'Edit Profil Akun')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Pesan Sukses/Error --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            Profil Anda berhasil diperbarui.
        </div>
    @elseif (session('status') === 'password-updated')
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            Kata sandi Anda berhasil diperbarui.
        </div>
    @elseif (session('status') === 'profile-deleted')
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            Akun Anda berhasil dihapus.
        </div>
    @endif

    {{-- Bagian Update Informasi Profil --}}
    <div class="bg-gray-800 shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-3">Informasi Profil</h3>
        <p class="text-gray-400 text-sm mb-6">Perbarui informasi profil akun Anda dan alamat email.</p>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-300">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('name') border-red-500 @enderror" required autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Bagian Update Kata Sandi --}}
    <div class="bg-gray-800 shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-3">Perbarui Kata Sandi</h3>
        <p class="text-gray-400 text-sm mb-6">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-300">Kata Sandi Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('current_password') border-red-500 @enderror" autocomplete="current-password" required>
                @error('current_password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-300">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('password') border-red-500 @enderror" autocomplete="new-password" required>
                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-300">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('password_confirmation') border-red-500 @enderror" autocomplete="new-password" required>
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Bagian Hapus Akun --}}
    <div class="bg-gray-800 shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-3">Hapus Akun</h3>
        <p class="text-gray-400 text-sm mb-6">Setelah akun Anda dihapus, semua sumber daya dan data Anda akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>

        {{-- Tombol untuk memicu modal konfirmasi --}}
        <button 
            type="button" 
            onclick="showDeleteAccountModal()" 
            class="inline-flex items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
            HAPUS AKUN
        </button>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS AKUN --}}
<div id="delete-account-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl max-w-md w-full text-gray-200">
        <h3 class="text-xl font-bold mb-4">Apakah Anda yakin ingin menghapus akun Anda?</h3>
        <p class="text-gray-400 text-sm mb-6">Setelah akun Anda dihapus, semua sumber daya dan data Anda akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-4">
                <label for="password_delete" class="sr-only">Kata Sandi</label>
                <input type="password" id="password_delete" name="password" placeholder="Kata Sandi Anda" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('password', 'userDeletion') border-red-500 @enderror" required>
                @error('password', 'userDeletion')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideDeleteAccountModal()" class="inline-flex items-center px-4 py-2 border border-gray-600 rounded-md font-semibold text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-700 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan modal
    function showDeleteAccountModal() {
        document.getElementById('delete-account-modal').classList.remove('hidden');
        document.getElementById('password_delete').focus(); // Fokus pada input password
    }

    // Fungsi untuk menyembunyikan modal
    function hideDeleteAccountModal() {
        document.getElementById('delete-account-modal').classList.add('hidden');
        document.getElementById('password_delete').value = ''; // Bersihkan input password
    }

    // Menangani error validasi dari server setelah submit modal
    @if ($errors->userDeletion->any())
        window.onload = function() { showDeleteAccountModal(); };
    @endif
</script>
@endsection
