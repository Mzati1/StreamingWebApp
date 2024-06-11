@extends('components.layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-20">

        <!-- Popular People -->
        <div class="popular-people-shows">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">
                <i class="fas fa-user text-orange-500 mr-2"></i> Popular Actors
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($popularPeople as $person)
                    <x-person-card :personID="$person['id']" :image="$person['profile_path']" :name="$person['name']" :knownForArray="$person['known_for']" />
                @endforeach
            </div>
        </div>

        <!-- Trending -->
        <div class="now-playing mt-10">
            <h2 class="uppercase tracking-wider text-primary text-lg font-semibold dark:text-primary-light">
                <i class="fa-solid fa-fire text-red-500 mr-2"></i> Trending This Week
            </h2>

            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($trendingPeople as $person)
                    <a href="{{ route('person.details', ['person_id' => $person['id']]) }}" class="relative group">
                        <img class="rounded-lg transition duration-300 transform group-hover:scale-105"
                            src="{{ config('services.tmdb.image_base_url') . $person['profile_path'] }}"
                            alt="{{ $person['name'] }}">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-75 transition duration-300">
                        </div>
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <h3 class="text-lg font-semibold text-white">{{ $person['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
