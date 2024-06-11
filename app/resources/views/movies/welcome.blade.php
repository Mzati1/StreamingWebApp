@extends('components.layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-20 dark:text-white">

        <!-- Popular movies -->
        <div class="popular-movies">
            <h2 class="uppercase tracking-wider text-primary text-lg font-semibold dark:text-primary-light">
                <i class="fa-solid fa-fire text-red-500 mr-2"></i> Popular Movies
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($movies as $movie)
                    <x-movie-card :imageURL="$movie['poster_path']" :title="$movie['title']" :date="$movie['release_date']" :genreArray="$movie['genre_ids']" :rating="$movie['vote_average']"
                        :genreMap=$genreMap :movieID="$movie['id']" />
                @endforeach
            </div>
        </div>

        <!-- Now playing -->
        <div class="now-playing mt-10">
            <h2 class="uppercase tracking-wider text-primary text-lg font-semibold dark:text-primary-light">
                <i class="fa-solid fa-play-circle text-green-500 mr-2"></i> Now Playing
            </h2>

            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($movies as $movie)
                    <a href="{{ route('movie.details', ['movie_id' => $movie['id']]) }}" class="relative group">
                        <img class="rounded-lg transition duration-300 transform group-hover:scale-105"
                            src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-75 transition duration-300">
                        </div>
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <h3 class="text-lg font-semibold text-white">{{ $movie['title'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endsection
