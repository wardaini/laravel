@extends('layouts.app')
@section('title', 'Manajemen Cuti')
@section('content')
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-small transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Manajemen Cuti</h1>
        @if (Auth::user()->role == 'admin')
            <p class="text-sm text-gray-400 mt-1">Kelola data pengajuan cuti seluruh karyawan.</p>
        @else
            <p class="text-sm text-gray-400 mt-1">Berikut adalah daftar riwayat pengajuan cuti Anda.</p>
        @endif
    </div>
    @if (session('success'))
        <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="mb-6">
            {{-- Tombol Ajukan Cuti selalu ada untuk pegawai --}}
            <a href="{{ route('cuti.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md">
                <i class="fas fa-plus mr-2"></i>Ajukan Cuti
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700 bg-opacity-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">No</th>
                        @if (Auth::user()->role == 'admin')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nama Karyawan</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tanggal Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Alasan</th> {{-- Tambahkan kolom Alasan --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($cuti as $index => $item)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $index + 1 }}</td>
                            @if (Auth::user()->role == 'admin')
                                <td class="px-6 py-4 text-sm font-medium text-gray-200">{{ $item->karyawan->nama ?? 'Karyawan Dihapus' }}</td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-300">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">{{ Str::limit($item->alasan, 50) }}</td> {{-- Tampilkan alasan --}}
                            <td class="px-6 py-4 text-sm">
                                @if($item->status == 'disetujui')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-200">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-900 text-red-200">Ditolak</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900 text-yellow-200">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center space-x-4">
                                {{-- Admin selalu bisa edit/hapus --}}
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('cuti.edit', $item->id_cuti) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('cuti.destroy', $item->id_cuti) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                    </form>
                                @else
                                    {{-- Pegawai hanya bisa edit/hapus jika statusnya pending --}}
                                    @if ($item->status == 'pending')
                                        <a href="{{ route('cuti.edit', $item->id_cuti) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('cuti.destroy', $item->id_cuti) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Tidak ada aksi</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role == 'admin' ? '6' : '5' }}" class="px-6 py-4 text-center text-gray-500">Tidak ada data cuti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection