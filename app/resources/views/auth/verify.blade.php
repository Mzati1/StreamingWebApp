@extends('components.layouts.validation')

@section('content')

<div class="container mx-auto flex items-center justify-center min-h-screen px-4 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="text-center text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ __('Verify Your Email Address') }}</div>

        <div class="mb-6">
            @if (session('resent'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ __('A fresh verification link has been sent to your email address.') }}</span>
                </div>
            @endif

            <p class="text-gray-700 dark:text-gray-300 mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ __('If you did not receive the email') }},</p>
            
            <form class="inline-block" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-blue-500 dark:text-blue-400">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>

@endsection
