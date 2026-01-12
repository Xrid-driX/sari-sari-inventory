<x-guest-layout>
    <!-- Custom Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
            Welcome Back!
        </h1>
        <p class="text-sm text-gray-500 mt-2">Sign in to manage your Sari-Sari Store</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="at-sign" class="h-5 w-5 text-gray-400"></i>
            </div>
            <x-text-input id="email" class="block mt-1 w-full pl-10 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm py-3"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
            </div>
            <x-text-input id="password" class="block mt-1 w-full pl-10 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 dark:focus:ring-purple-600 dark:bg-gray-900 dark:border-gray-700" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 text-lg bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 rounded-xl">
                {{ __('Log In') }} <i data-lucide="log-in" class="ml-2 h-5 w-5"></i>
            </x-primary-button>
        </div>

        <!-- Register Link Section -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-bold text-purple-600 hover:text-purple-800 hover:underline">
                    Register here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
