<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    {{-- Livewire styles --}}
    <livewire:styles />

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>

    {{-- Vite asset bundling --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Swiper JS and CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/e99d0fa6e7.js" crossorigin="anonymous"></script>
</head>

<body x-data="{ isLoading: true }" x-init="$nextTick(() => isLoading = false)" :class="{ 'dark': darkMode }" class="transition-colors duration-300">
    <div x-show="isLoading" class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="flex items-center justify-center space-x-2">
            <div class="w-8 h-8 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="w-8 h-8 bg-green-500 rounded-full animate-bounce"></div>
            <div class="w-8 h-8 bg-red-500 rounded-full animate-bounce"></div>
        </div>
    </div>

    <!-- Navigation -->
    <x-navigation />

    @yield('content')

    <!-- Footer -->
    <x-footer />

    {{-- Livewire scripts --}}
    <livewire:scripts />

</body>

</html>
