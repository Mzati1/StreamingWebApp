@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="max-w-md w-full mx-auto p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ __('Reset Password') }}</h2>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Address -->
                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200"
                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label for="password"
                        class="block mt-4 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Password') }}</label>
                    <div class="relative">
                        <input id="password" type="password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200"
                            name="password" required autocomplete="new-password">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" @click="showPassword = !showPassword"
                                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M16.07 9.54a9 9 0 011.96 4.34A4.97 4.97 0 0113 19.62a9 9 0 01-7-7 4.97 4.97 0 014.74-7.11 9 9 0 014.34 1.96l1.49-1.49a1 1 0 011.41 1.41l-1.42 1.42zm-4.3 2.92a2 2 0 102.83 2.83 2 2 0 00-2.83-2.83z">
                                    </path>
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M17.6 21.4a9 9 0 01-12.68-12.68M12 2v4m0 8v4m-6-6h4m8 0h4m-4 6h4m-8 0h4m6-10a9 9 0 0112.68 12.68M19 22.94a9 9 0 01-14.12 0">
                                    </path>
                                </svg>
                            </button>
                        </span>
                    </div>
                    @error('password')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password-confirm"
                        class="block mt-4 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200"
                        name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- Reset Password Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection
