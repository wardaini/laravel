@extends('layouts.app')

@section('title', 'Manajemen Kehadiran')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Manajemen Kehadiran</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola data kehadiran harian seluruh karyawan.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="mb-6">
            <a href="{{ route('kehadiran.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md">
                <i class="fas fa-plus mr-2"></i>Catat Kehadiran
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700 bg-opacity-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nama Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($kehadiran as $item)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm text-gray-300">{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-200">{{ $item->karyawan->nama }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($item->status == 'hadir') bg-green-900 text-green-200 @endif
                                    @if($item->status == 'sakit') bg-yellow-900 text-yellow-200 @endif
                                    @if($item->status == 'izin') bg-blue-900 text-blue-200 @endif
                                    @if($item->status == 'alfa') bg-red-900 text-red-200 @endif
                                ">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center space-x-4">
                                <a href="{{ route('kehadiran.edit', $item->id_kehadiran) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                <form action="{{ route('kehadiran.destroy', $item->id_kehadiran) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data kehadiran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
