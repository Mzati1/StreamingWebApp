@extends('components.layouts.app')

@section('content')
    <div class="profile-info border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row items-center">
            <div class="flex-shrink-0">
                <img src="{{ $user['profile_picture'] }}" alt="{{ $user['name'] }} Profile Picture"
                    class="w-32 h-32 rounded-full">
            </div>
            <div class="md:ml-8 mt-4 md:mt-0 text-center md:text-left">
                <h2 class="text-4xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $user['name'] }}</h2>
                <p class="text-gray-800 dark:text-gray-400">{{ $user['email'] }}</p>
                <button type="button" @click="isEditing = true" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                    Edit Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Edit Form -->
    <div x-data="{ isEditing: false }" x-show="isEditing" class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
            Edit Profile
        </h2>
        <form action="" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input type="text" name="name" id="name" value="{{ $user['name'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ $user['email'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="profile_picture">
                    Profile Picture
                </label>
                <input type="file" name="profile_picture" id="profile_picture"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save
                </button>
                <button type="button" @click="isEditing = false"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Lists -->
    <div class="user-lists border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
                <i class="fas fa-list text-indigo-500 mr-2"></i> Your Lists
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($userLists as $list)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $list['name'] }}</h3>
                        <p class="text-gray-800 dark:text-gray-400">{{ $list['description'] }}</p>
                        <a href="" class="text-blue-500 hover:underline mt-4 block">View List</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Watchlist -->
    <div class="user-watchlist border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
                <i class="fas fa-bookmark text-red-500 mr-2"></i> Your Watchlist
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($watchlist as $movie)
                    <x-movie-card :imageURL="$movie['poster_path']" :title="$movie['title']" :date="$movie['release_date']" :genreArray="$movie['genre_ids']" :rating="$movie['vote_average']"
                        :genreMap="$genreMap" :movieID="$movie['id']" />
                @endforeach
            </div>
        </div>
    </div>

    <!-- Watch History -->
    <div class="user-watch-history border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
                <i class="fas fa-history text-green-500 mr-2"></i> Your Watch History
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($watchHistory as $history)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <a href="">
                            <img src="{{ $history['movie']['poster_path'] }}" alt="{{ $history['movie']['title'] }} Poster"
                                class="w-full h-auto rounded-lg">
                        </a>
                        <div class="p-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $history['movie']['title'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $history['movie']['release_date'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($history['watched_at'])->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
