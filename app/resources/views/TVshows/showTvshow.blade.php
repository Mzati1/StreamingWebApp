@extends('components.layouts.app')

@section('content')
    <div class="show-info border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <img src="{{ config('services.tmdb.image_base_url') . $tvShow['poster_path'] }}"
                alt="{{ $tvShow['name'] }} IMAGE NOT FOUND" class="w-64 md:w-96">

            <div class="md:ml-24">

                <h2 class="text-4xl font-semibold text-gray-900 dark:text-gray-100 mb-5">{{ $tvShow['name'] }}</h2>

                <div class="flex flex-wrap items-center text-gray-400 text-sm dark:text-gray-300">
                    <span><i class="fas fa-star text-yellow-500 mr-1"></i></span>
                    <span class="ml-1">{{ round($tvShow['vote_average'] * 10, 1) }} %</span>
                    <span class="mx-2">|</span>
                    <span>{{ Carbon\Carbon::parse($tvShow['first_air_date'])->format('M d, Y') }}</span>
                    <span class="mx-2">|</span>
                    <span class="mx-2">
                        @foreach ($tvShow['genres'] as $genre)
                            <span> {{ $genre['name'] }} </span>
                        @endforeach
                    </span>
                </div>

                <p class="text-gray-300 mt-8 dark:text-gray-400">
                    {{ $tvShow['overview'] }}
                </p>

                <div class="mt-12">
                    <div x-data="{ isOpen: false }">
                        <div class="mt-12 flex space-x-4">
                            <button
                                class="flex inline-flex items-center bg-blue-500 text-white rounded font-semibold px-5 py-4 hover:bg-blue-600 transition ease-in-out duration-150">
                                <i class="fas fa-plus-circle text-white mr-2"></i>
                                <span>Add to Watchlist</span>
                            </button>
                            <button @click="isOpen = true"
                                class="flex inline-flex items-center bg-orange-500 text-gray-900 dark:text-gray-100 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150">
                                <i class="fas fa-play-circle text-white mr-2"></i>
                                <span>Play Trailer</span>
                            </button>
                            <a href="{{ route('serie.watchNow', ['tvID' => $tvShow['id']]) }}">
                                <button
                                    class="flex inline-flex items-center bg-red-500 text-white rounded font-semibold px-5 py-4 hover:bg-red-600 transition ease-in-out duration-150">
                                    <i class="fas fa-play-circle mr-2"></i>
                                    <span>Watch Now</span>
                                </button>
                            </a>
                        </div>

                        <template x-if="isOpen">
                            <div style="background-color: rgba(0, 0, 0, .5);"
                                class="fixed z-50 top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
                                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                    <div class="bg-gray-900 rounded">
                                        <div class="flex justify-end pr-4 pt-2">
                                            <button @click="isOpen = false" @keydown.escape.window="isOpen = false"
                                                class="text-3xl leading-none hover:text-gray-300">&times;
                                            </button>
                                        </div>
                                        <div class="modal-body px-8 py-8">
                                            <div class="responsive-container overflow-hidden relative"
                                                style="padding-top: 56.25%">
                                                @if ($tvShowVideo)
                                                    <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                        src="https://www.youtube.com/embed/{{ $tvShowVideo[0]['key'] }}"
                                                        style="border:0;" allow="autoplay; encrypted-media"
                                                        allowfullscreen></iframe>
                                                @else
                                                    <p class="text-white text-center">Trailer not available</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="show-cast border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
                <i class="fas fa-users text-indigo-500 mr-2"></i> Cast
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($credits as $cast)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                        <a href="{{ route('person.details', ['person_id' => $cast['id']]) }}">
                            <img src="{{ config('services.tmdb.image_base_url') . $cast['profile_path'] }}"
                                alt="{{ $cast['name'] }} Profile Image" class="w-full h-auto rounded-t-lg">
                        </a>
                        <div class="p-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $cast['name'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $cast['character'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <!--images-->
    <div class="movie-images border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold text-gray-900 dark:text-gray-100">
                <i class="fas fa-images text-blue-500 mr-2"></i> Images
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($tvShowImages as $image)
                    <x-showImageSnapshot :imageURL="$image['file_path']" :imageHeight="$image['height']" :imageWidth="$image['width']" />
                @endforeach
            </div>

        </div>
    </div>

    <!--recommendations-->
    <div class="movie-recommendations border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8">
                <i class="fa-solid fa-fire text-red-500 mr-2"></i> You might also like:
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($recommendations as $show)
                    <x-tv-card :imageURL="$show['poster_path']" :title="$show['name']" :date="$show['first_air_date']" :genreArray="$show['genre_ids']" :genreMap=$genreMap
                        :rating="$show['vote_average']" :tvID="$show['id']" />
                @endforeach
            </div>
        </div>
    </div>
@endsection
