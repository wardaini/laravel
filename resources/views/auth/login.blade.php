<x-guest-layout>
    {{-- Header Form --}}
    <div class="mb-8">
        <h3 class="text-3xl font-bold">Login</h3>
        <p class="text-gray-400 mt-2">Enter your account details</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-6">
            <!-- Username -->
            <div>
                <label for="username" class="text-sm font-medium text-gray-400">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus 
                       class="block w-full mt-1 px-3 py-3 bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between">
                    <label for="password" class="text-sm font-medium text-gray-400">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-400 hover:text-indigo-300" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="block w-full mt-1 px-3 py-3 bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <!-- Tombol Login dan Link Register -->
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                    Login
                </button>
                <p class="text-center text-sm text-gray-400 mt-4">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300">Sign up</a>
                </p>
            </div>
        </div>
    </form>

    {{-- ======================================================= --}}
    {{-- NAMA KELOMPOK (BAGIAN BARU) --}}
    {{-- ======================================================= --}}
    <div class="text-center mt-8 text-sm text-gray-500">
        <p class="mb-1">Tim Pengembang - Kelompok 4 (A2)</p>
        <p class="font-semibold text-gray-400">Wardatul A'ani &bull; Latifatus Zahro &bull; Dinda</p>
    </div>
</x-guest-layout>
