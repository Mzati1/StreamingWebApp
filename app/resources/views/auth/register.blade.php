@extends('components.layouts.validation')

@section('content')
    <div class="container mx-auto flex items-center justify-center min-h-screen px-4 bg-gray-100 dark:bg-gray-900">
        <div x-data="{ showPassword: false, passwordStrength: '' }" class="w-full max-w-3xl p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">Create an Account</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label for="first_name" class="label">
                            <span class="label-text dark:text-gray-300">First Name</span>
                        </label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                            class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('first_name') is-invalid @enderror">
                        @error('first_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label for="last_name" class="label">
                            <span class="label-text dark:text-gray-300">Last Name</span>
                        </label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                            class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('last_name') is-invalid @enderror">
                        @error('last_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label for="email" class="label">
                            <span class="label-text dark:text-gray-300">Email</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label for="dob" class="label">
                            <span class="label-text dark:text-gray-300">Date of Birth</span>
                        </label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob') }}" required
                            class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('dob') is-invalid @enderror">
                        @error('dob')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control col-span-1 md:col-span-2" x-data="{ password: '' }">
                        <label for="password" class="label">
                            <span class="label-text dark:text-gray-300">Password</span>
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                x-model="password"
                                @input="passwordStrength = password.length < 6 ? 'weak' : password.length < 10 ? 'medium' : 'strong'"
                                required
                                class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300 @error('password') is-invalid @enderror">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 dark:text-gray-400">
                                <span x-show="!showPassword">🙈</span>
                                <span x-show="showPassword">🙉</span>
                            </button>
                        </div>
                        <p class="mt-2 text-sm"
                            :class="{ 'text-red-600': passwordStrength === 'weak', 'text-yellow-600': passwordStrength === 'medium', 'text-green-600': passwordStrength === 'strong' }">
                            Password Strength: <span
                                x-text="passwordStrength.charAt(0).toUpperCase() + passwordStrength.slice(1)"></span>
                        </p>
                        @error('password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control col-span-1 md:col-span-2">
                        <label for="password_confirmation" class="label">
                            <span class="label-text dark:text-gray-300">Confirm Password</span>
                        </label>
                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                            name="password_confirmation" required
                            class="input input-bordered w-full dark:bg-gray-700 dark:text-gray-300">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full mt-6">Register</button>
            </form>
            <p class="text-center text-gray-600 dark:text-gray-400 mt-4">Already have an account? <a href="/login"
                    class="text-blue-500 dark:text-blue-400">Login</a></p>
        </div>
    </div>
@endsection
