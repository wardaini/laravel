@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
    {{-- Tombol kembali dari desain Anda --}}
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-small transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Header Halaman dari desain Anda --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Manajemen Karyawan</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola data seluruh karyawan di perusahaan Anda.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Kartu konten gelap dari desain Anda --}}
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <a href="{{ route('karyawan.create') }}" class="w-full sm:w-auto inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all">
                <i class="fas fa-plus mr-2"></i>Tambah Karyawan
            </a>
            <form action="{{ route('karyawan.index') }}" method="GET" class="w-full sm:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" name="search" class="w-full sm:w-64 pl-10 pr-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-2 focus:ring-indigo-500 transition" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700 bg-opacity-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Golongan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($karyawans as $index => $item)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $karyawans->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($item->foto_profil)
                                            {{-- PERBAIKAN UTAMA: Menggunakan rute 'karyawan.foto' untuk menampilkan gambar --}}
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ route('karyawan.foto', ['filename' => basename($item->foto_profil)]) }}" alt="Foto profil {{ $item->nama }}">
                                        @else
                                            {{-- Menggunakan placeholder SVG jika tidak ada foto --}}
                                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-200">{{ $item->nama }}</div>
                                        <div class="text-sm text-gray-400">{{ $item->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $item->nip ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $item->jabatan->nama_jabatan ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $item->golongan->nama_golongan ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center space-x-4">
                                <a href="{{ route('karyawan.show', $item->id_karyawan) }}" class="text-green-400 hover:text-green-300">Detail</a>
                                <a href="{{ route('karyawan.edit', $item->id_karyawan) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                <form action="{{ route('karyawan.destroy', $item->id_karyawan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data karyawan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($karyawans->hasPages())
            <div class="mt-6">
                {{ $karyawans->links() }}
            </div>
        @endif
    </div>
@endsection
