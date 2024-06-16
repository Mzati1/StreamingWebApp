<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">

    <!-- Styles -->
    <style>
        /* Add any custom styles here */
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div id="app">
        <div x-data="{ isOpen: false, scrolled: false }" x-init="window.onscroll = () => scrolled = window.scrollY > 50"
            class="sticky top-4 z-50 transition-all duration-300 ease-in-out">
            <nav :class="{ 'bg-opacity-75': scrolled }"
                class="navbar glass bg-opacity-60 dark:bg-opacity-30 px-4 rounded-lg mx-auto max-w-5xl shadow-lg">
                <!-- Left Side: Logo and App Name -->
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-xl font-bold text-gray-800 dark:text-gray-200">Movies app</a>
                </div>

                <!-- Spacer to push right side elements to the edge -->
                <div class="flex-grow"></div>

                <!-- Right Side: Authentication Links and Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <!-- Authentication Links -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-ghost">Register</a>
                        @endif
                    @else
                        <!-- Profile Dropdown -->
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full overflow-hidden">
                                    <!-- Replace with actual user profile image -->
                                    <img src="https://via.placeholder.com/150" alt="Profile Image">
                                </div>
                            </div>
                            <ul tabindex="0"
                                class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 dark:bg-base-700 rounded-box w-52">
                                <li><a href="#" class="justify-between">Profile</a></li>
                                <li><a href="#" class="justify-between">Watchlist</a></li>
                                <li><a href="#" class="justify-between">Settings</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="justify-between">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button @click="isOpen = !isOpen" class="text-gray-800 dark:text-gray-200 focus:outline-none">
                            <svg x-show="!isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                                <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Mobile Menu -->
            <div x-show="isOpen" class="md:hidden bg-white dark:bg-gray-900">
                <ul class="flex flex-col space-y-4">
                    @guest
                        <li><a href="{{ route('login') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Register</a>
                            </li>
                        @endif
                    @else
                        <li><a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                        </li>
                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <div x-data="{ scrolled: false }" x-init="window.onscroll = () => scrolled = window.scrollY > 50" class="fixed bottom-4 right-4 z-50">
            <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-show="scrolled"
                class="btn btn-circle btn-primary shadow-lg transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
