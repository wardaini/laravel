{{-- <x-app-layout>
    @php
        $absensiHariIni = $absensiHariIni ?? null;
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absen Masuk / Pulang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <!-- Absen Masuk -->
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Absen Masuk
                    </button>
                </form>

                <!-- Absen Pulang -->
                @if($absensiHariIni)
                <form action="{{ route('absensi.update', $absensiHariIni->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Absen Pulang
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout> --}}
