@extends('components.layouts.validation')

@section('content')
    <div class="container mx-auto flex items-center justify-center min-h-screen px-4 bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">Login to Your Account</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text dark:text-gray-300">Email Address</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('email') is-invalid @enderror">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text dark:text-gray-300">Password</span>
                    </label>
                    <input type="password" id="password" name="password" required
                        class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="checkbox dark:bg-gray-700 dark:text-gray-300" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2 dark:text-gray-300">Remember Me</span>
                    </label>
                </div>
                <div class="form-control mb-4">
                    <button type="submit" class="btn btn-primary w-full">Login</button>
                </div>
                <div class="text-center">
                    <a class="text-blue-500 dark:text-blue-400" href="{{ route('register') }}">
                        Create an Account
                    </a>
                    @if (Route::has('password.request'))
                        <a class="ml-2 text-blue-500 dark:text-blue-400" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
