@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="max-w-md w-full mx-auto p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ __('Verify Your Email Address') }}
                </h2>
            </div>

            <div class="mt-4">
                @if (session('resent'))
                    <div id="notification"
                        class="fixed bottom-0 right-0 mb-4 mr-4 p-4 bg-green-500 text-white rounded shadow-lg z-50"
                        style="display: none;">
                        <p>{{ session('resent') }}</p>
                    </div>
                @endif

                @if (session('sucess'))
                    <div id="notification"
                        class="fixed bottom-0 right-0 mb-4 mr-4 p-4 bg-green-500 text-white rounded shadow-lg z-50"
                        style="display: none;">
                        <p>{{ session('sucess') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div id="notification"
                        class="fixed bottom-0 right-0 mb-4 mr-4 p-4 bg-red-500 text-white rounded shadow-lg z-50"
                        style="display: none;">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <p class="text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                </p>

                {{-- Resend link form --}}
                <form id="resendForm" class="mt-2" action="{{ route('user.verify.resend') }}" method="POST"
                    onsubmit="return validateEmail()">
                    @csrf
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                    <button type="submit"
                        class="inline-block mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        {{ __('Resend Link') }}
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- JavaScript to handle notification display and validation -->
    <script>
        // Function to show notification
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.innerHTML = `<p>${message}</p>`;
                notification.classList.remove('hidden');
                notification.classList.remove('bg-green-500', 'bg-red-500');
                notification.classList.add(type);
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 5000);
            }
        }

        // Client-side email validation
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const email = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address.', 'bg-red-500');
                return false;
            }
            return true;
        }

        // Check for session messages and show corresponding notification
        @if (session('resent'))
            showNotification("{{ session('resent') }}", 'bg-green-500');
        @endif

        @if (session('error'))
            showNotification("{{ session('error') }}", 'bg-red-500');
        @endif

        @if (session('sucess'))
            showNotification("{{ session('sucess') }}", 'bg-green-500');
        @endif
    </script>
@endsection
