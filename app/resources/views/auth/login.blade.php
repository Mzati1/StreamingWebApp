@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">{{ __('Login') }}</h2>

            {{-- Popup message --}}
            @if (session('success'))
                <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    <div class="flex items-center">
                        <div class="text-lg">
                            <svg class="h-6 w-6 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <div class="flex items-center">
                        <div class="text-lg">
                            <svg class="h-6 w-6 text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-bold">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                        Address</label>
                    <input id="email" type="email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input id="password" type="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 dark:text-gray-400 dark:focus:ring-gray-600 dark:checked:bg-gray-700 rounded"
                            type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Remember
                            me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 dark:text-gray-400 hover:underline"
                            href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript to handle popup message --}}
    <script>
        // Wait until the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // If there is a success message, show the success popup and then hide it after 5 seconds
            let successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }

            // If there is an error message, show the error popup and then hide it after 5 seconds
            let errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>
@endsection
