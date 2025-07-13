<x-guest-layout :pageTitle="$pageTitle">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Masuk
        </h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                placeholder="••••••••"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Remember Me -->
            {{-- <div class="flex items-end justify-end my-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                      <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="ms-2 text-sm text-gray-500 dark:text-gray-300">{{ __('Remember me') }}</span>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-[#0ea5e9] hover:underline dark:text-primary-500" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div> --}}
    
            <x-primary-button class="mt-4">
                {{ __('Masuk') }}
            </x-primary-button>

            <p class="mt-4 text-sm font-light text-gray-500 dark:text-gray-400">
                {{ __('Belum memiliki akun?') }} 
                <a href="{{ route('register') }}" class="font-medium text-[#0ea5e9] hover:underline dark:text-primary-500">Daftar</a>
            </p>
        </form>
    </div>
</x-guest-layout>