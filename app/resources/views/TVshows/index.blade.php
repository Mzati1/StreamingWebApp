@extends('components.layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-20">

        <!-- Popular TV Shows -->
        <div class="popular-tv-shows">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">
                <i class="fas fa-tv text-orange-500 mr-2"></i> Popular TV Shows
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($tvshows as $show)
                    <x-tv-card :imageURL="$show['poster_path']" :title="$show['name']" :date="$show['first_air_date']" :genreArray="$show['genre_ids']" :genreMap=$genreMap
                        :rating="$show['vote_average']" :tvID="$show['id']" />
                @endforeach
            </div>
        </div>

        <!-- Now Playing -->
        <div class="now-playing mt-10">
            <h2 class="uppercase tracking-wider text-primary text-lg font-semibold dark:text-primary-light">
                <i class="fas fa-play-circle text-primary mr-2"></i> Now Playing
            </h2>

            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($nowPlayingShows as $show)
                    <a href="{{ route('movie.details', ['movie_id' => $show['id']]) }}" class="relative group">
                        <img class="rounded-lg transition duration-300 transform group-hover:scale-105"
                            src="{{ config('services.tmdb.image_base_url') . $show['poster_path'] }}"
                            alt="{{ $show['name'] }}">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-75 transition duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <h3 class="text-lg font-semibold text-white">{{ $show['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
