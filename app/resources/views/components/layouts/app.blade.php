<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    {{-- Livewire styles --}}
    <livewire:styles />

    {{-- alphine js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>

    {{-- Vite asset bundling --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Swiper JS and CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="https://kit.fontawesome.com/e99d0fa6e7.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation -->
    <x-navigation />

    @yield('content')

    <!-- Footer -->
    <x-footer />

    {{-- Livewire scripts --}}
    <livewire:scripts />

</body>

</html>
