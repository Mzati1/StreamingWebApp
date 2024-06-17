<!-- Sticky Navbar with Glass Effect -->
<div x-data="{ scrolled: false }" x-init="window.onscroll = () => scrolled = window.scrollY > 50" class="sticky top-4 z-50 transition-all duration-300 ease-in-out">
    <div class="navbar glass bg-opacity-60 dark:bg-opacity-30 px-4 rounded-lg mx-auto max-w-5xl shadow-lg"
        :class="{ 'bg-opacity-75': scrolled }">
        <!-- Left Side: Logo and Movies App button -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('movie.index') }}" class="btn btn-ghost flex items-center space-x-2">
                <i class="fas fa-film text-xl"></i>
                <span class="text-xl font-bold">Movies app</span>
            </a>

            <a href="{{ route('movie.index') }}" class="btn btn-ghost ml-6">Movies</a>
            <a href="{{ route('series.index') }}" class="btn btn-ghost ml-6">TV shows</a>
            <a href="{{ route('people.index') }}" class="btn btn-ghost ml-6">Actors</a>
        </div>
        <!-- Spacer to push right side elements to the edge -->
        <div class="flex-grow"></div>
        <!-- Right Side: Search and Profile -->
        <div class="flex items-center space-x-4">
            <livewire:search-dropdown />
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        @auth
                            <img alt="Profile Image" src="{{ Auth::user()->profile_photo_url }}" />
                        @else
                            <img alt="Stock Image"
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                        @endauth
                    </div>
                </div>
                <ul tabindex="0"
                    class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 dark:bg-base-700 rounded-box w-52">
                    @auth
                        <li>
                            <a href="{{ route('user.profile') }}">Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile') }}">Watchlist</a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile') }}">Settings</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li>
                            <a href="{{ route('register') }}">Profile
                                <span class="badge">Register</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Watchlist
                                <span class="badge">Register</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">
                                Settings
                                <span class="badge">Register</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}">
                                <button type="submit">Login</button>
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
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
