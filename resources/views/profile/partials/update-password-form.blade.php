<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            Perbarui Kata Sandi
        </h2>
        <p class="mt-1 text-sm text-gray-300">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            {{-- [FINAL] Warna label diubah menjadi putih --}}
            <x-input-label for="current_password" value="Kata Sandi Saat Ini" class="text-white" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            {{-- [FINAL] Warna label diubah menjadi putih --}}
            <x-input-label for="password" value="Kata Sandi Baru" class="text-white" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full bg-gamma-700 border-gray-600 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            {{-- [FINAL] Warna label diubah menjadi putih --}}
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="text-white" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
             <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">Simpan</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-400">{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>