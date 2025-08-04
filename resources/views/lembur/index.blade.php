@extends('layouts.app')

@section('title', 'Daftar Lembur')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center">
    <h1 class="text-3xl font-extrabold text-gray-100 mb-4 sm:mb-0">Daftar Lembur Karyawan</h1>
    <a href="{{ route('lembur.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
        <i class="fas fa-plus-circle mr-2"></i> Ajukan Lembur Baru
    </a>
</div>

<div class="bg-gray-800 p-6 rounded-xl shadow-2xl overflow-x-auto border border-gray-700">
    @if ($lemburs->isEmpty())
        <div class="text-center py-8 text-gray-400">
            <p class="text-lg mb-2">Belum ada data lembur yang tersedia.</p>
            <p>Silakan ajukan lembur pertama Anda!</p>
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-700 text-gray-300">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Jam Mulai</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Jam Selesai</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Durasi</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($lemburs as $lembur)
                    <tr class="hover:bg-gray-750 transition duration-150 ease-in-out">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $lembur->karyawan->nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $lembur->tanggal_lembur->format('d M Y') }}</td> {{-- Format lebih mudah dibaca --}}
                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($lembur->jam_mulai)->format('H:i') }}</td> {{-- Pastikan format H:i --}}
                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($lembur->jam_selesai)->format('H:i') }}</td> {{-- Pastikan format H:i --}}
                        <td class="px-4 py-3 whitespace-nowrap">{{ abs($lembur->durasi_jam) }} jam</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusClass = '';
                                switch ($lembur->status) {
                                    case 'pending':
                                        $statusClass = 'bg-yellow-500';
                                        break;
                                    case 'disetujui':
                                        $statusClass = 'bg-green-600';
                                        break;
                                    case 'ditolak':
                                        $statusClass = 'bg-red-600';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-500';
                                        break;
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold text-white {{ $statusClass }}">
                                {{ ucfirst($lembur->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex flex-wrap justify-center gap-2"> {{-- Gunakan justify-center untuk tombol aksi --}}
                                @if (Auth::user()->role === 'admin' || Auth::user()->karyawan->id_karyawan === $lembur->karyawan_id)
                                    <a href="{{ route('lembur.edit', $lembur->id_lembur) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form action="{{ route('lembur.destroy', $lembur->id_lembur) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lembur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif

                                @if (Auth::user()->role === 'admin' && $lembur->status === 'pending')
                                    <form action="{{ route('lembur.approve', $lembur->id_lembur) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                                            <i class="fas fa-check-circle mr-1"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('lembur.reject', $lembur->id_lembur) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-400 hover:bg-red-500 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                                            <i class="fas fa-times-circle mr-1"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection