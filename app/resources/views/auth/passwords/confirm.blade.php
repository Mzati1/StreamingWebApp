@extends('components.layouts.validation')

@section('content')
    <div class="container mx-auto flex items-center justify-center min-h-screen px-4 bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ __('Confirm Password') }}
            </div>

            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ __('Please confirm your password before continuing.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text dark:text-gray-300">{{ __('Password') }}</span>
                    </label>
                    <input id="password" type="password"
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-0">
                    <button type="submit" class="btn btn-primary w-full">{{ __('Confirm Password') }}</button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a class="text-blue-500 dark:text-blue-400" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
