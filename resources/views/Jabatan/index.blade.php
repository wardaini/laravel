@extends('layouts.app')

@section('title', 'Manajemen Jabatan')

@section('content')
    {{-- [PERUBAHAN] Tombol kembali sekarang berada di atas judul --}}
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-small transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
    {{-- Header dengan teks terang --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Manajemen Jabatan</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola data jabatan untuk sistem kepegawaian Anda.</p>
    </div>

    {{-- Notifikasi Sukses dengan tema gelap --}}
    @if (session('success'))
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- [PERUBAHAN] Kartu konten diubah menjadi gelap --}}
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            {{-- Tombol Tambah Data --}}
            <a href="{{ route('jabatan.create') }}" class="w-full sm:w-auto inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all">
                <i class="fas fa-plus mr-2"></i>Tambah Jabatan
            </a>
        </div>

        {{-- Tabel Data dengan tema gelap --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                {{-- [PERUBAHAN] Header tabel dengan latar dan border yang lebih jelas --}}
                <thead class="bg-gray-700 bg-opacity-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                {{-- [PERUBAHAN] Warna garis pemisah dan teks diubah agar kontras --}}
                <tbody class="divide-y divide-gray-700">
                    @forelse ($jabatan as $index => $item)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">{{ $item->nama_jabatan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-4">
                                <a href="{{ route('jabatan.edit', $item->id_jabatan) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                <form action="{{ route('jabatan.destroy', $item->id_jabatan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data jabatan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
