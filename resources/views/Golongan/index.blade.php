@extends('layouts.app')

@section('title', 'Manajemen Golongan')

@section('content')
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-small transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Manajemen Golongan</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola data golongan & komponen gaji.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="mb-6">
            <a href="{{ route('golongan.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md">
                <i class="fas fa-plus mr-2"></i>Tambah Golongan
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-700 bg-opacity-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Golongan</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Gaji Pokok</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Tunjangan Keluarga</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Uang Makan</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Uang Transport</th>
                        {{-- PERBAIKAN: Menambahkan kolom THR --}}
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">THR</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">BPJS/Tanggungan</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Bonus Tahunan</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($golongan as $index => $item)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-200">{{ $item->nama_golongan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->tunjangan_keluarga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->uang_makan_bulanan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->uang_transport_bulanan, 0, ',', '.') }}</td>
                            {{-- PERBAIKAN: Menampilkan data THR --}}
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->thr_nominal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->bpjs_per_tanggungan, 0, ',', '.') }}</td>
                            {{-- PERBAIKAN: Menggunakan nama kolom yang benar 'bonus_tahunan' --}}
                            <td class="px-6 py-4 text-sm text-gray-300">Rp {{ number_format($item->bonus_tahunan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center space-x-4">
                                <a href="{{ route('golongan.edit',['golongan'=> $item->id_golongan]) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                <form action="{{ route('golongan.destroy', $item->id_golongan) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-gray-500">Tidak ada data golongan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
