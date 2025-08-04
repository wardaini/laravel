<x-guest-layout>
    {{-- Header Form --}}
    <div class="mb-8">
        <h3 class="text-3xl font-bold">Create an Account</h3>
        <p class="text-gray-400 mt-2">Let's get started with your new account.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-4">
            <!-- Name -->
            <div>
                <label for="name" class="text-sm font-medium text-gray-400">Nama Lengkap</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-circle text-gray-500"></i>
                    </div>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="text-sm font-medium text-gray-400">Username</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-at text-gray-500"></i>
                    </div>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="text-sm font-medium text-gray-400">Alamat Email</label>
                 <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-500"></i>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="text-sm font-medium text-gray-400">Password</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-500"></i>
                    </div>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="text-sm font-medium text-gray-400">Konfirmasi Password</label>
                 <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-circle text-gray-500"></i>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-8">
             <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                Register
            </button>
            <p class="text-center text-sm text-gray-400 mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300">Login</a>
            </p>
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
