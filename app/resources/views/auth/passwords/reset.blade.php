@extends('components.layouts.validation')

@section('content')
    <div class="container mx-auto flex items-center justify-center min-h-screen px-4 bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ __('Reset Password') }}
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text dark:text-gray-300">{{ __('Email Address') }}</span>
                    </label>
                    <input id="email" type="email"
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('email') is-invalid @enderror"
                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text dark:text-gray-300">{{ __('Password') }}</span>
                    </label>
                    <input id="password" type="password"
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label for="password-confirm" class="label">
                        <span class="label-text dark:text-gray-300">{{ __('Confirm Password') }}</span>
                    </label>
                    <input id="password-confirm" type="password"
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300" name="password_confirmation"
                        required autocomplete="new-password">
                </div>

                <div class="form-control mb-0">
                    <button type="submit" class="btn btn-primary w-full">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
