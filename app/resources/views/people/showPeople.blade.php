@extends('components.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <img src="{{ config('services.tmdb.image_base_url') . $person['profile_path'] }}" alt="profile image"
                    class="w-64 h-auto rounded-lg shadow-lg">
                <ul class="flex items-end mt-4 space-x-2">
                    @foreach ($personExternalIds as $social => $id)
                        @if ($id)
                            @php
                                $socialUrl = '';
                                switch ($social) {
                                    case 'instagram_id':
                                        $socialUrl = 'https://instagram.com/' . $id;
                                        break;
                                    case 'youtube_id':
                                        $socialUrl = 'https://youtube.com/' . $id;
                                        break;
                                    case 'facebook_id':
                                        $socialUrl = 'https://facebook.com/' . $id;
                                        break;
                                    case 'twitter_id':
                                        $socialUrl = 'https://twitter.com/' . $id;
                                        break;
                                    case 'linkedin_id':
                                        $socialUrl = 'https://linkedin.com/in/' . $id;
                                        break;

                                    default:
                                        $socialUrl = 'https://www.google.com/search?q=social tmdb id:' . $id;
                                }
                            @endphp
                            @if ($socialUrl)
                                <li>
                                    <a href="{{ $socialUrl }}" title="{{ ucfirst($social) }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-gray-400 hover:text-{{ $social === 'instagram_id' ? 'pink' : ($social === 'youtube_id' ? 'red' : ($social === 'twitter_id' ? 'blue' : ($social === 'facebook_id' ? 'indigo' : $social))) }}-500">
                                        <i
                                            class="fab fa-{{ $social === 'instagram_id' ? 'instagram' : ($social === 'youtube_id' ? 'youtube' : ($social === 'twitter_id' ? 'twitter' : ($social === 'facebook_id' ? 'facebook' : $social))) }} fa-2x"></i>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach




                    @if ($person['homepage'])
                        <li>
                            <a href="{{ $person['homepage'] }}" title="Website" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-globe fa-2x"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="md:ml-8 mt-4 md:mt-0 overflow-x-hidden">
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white">{{ $person['name'] }}</h2>
                <div class="flex items-center text-gray-500 text-sm mt-2">
                    <i class="fas fa-birthday-cake"></i>
                    @php
                        $birthDate = new DateTime($person['birthday']);
                        $currentDate = new DateTime();
                        $age = $currentDate->diff($birthDate)->y;
                    @endphp
                    <span class="ml-2">{{ Carbon\Carbon::parse($person['birthday'])->format('M d, Y') }}
                        ({{ $age }} years old) in
                        {{ $person['place_of_birth'] }}</span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mt-4">
                    @if (strlen($person['biography']) > 200)
                        {{ substr($person['biography'], 0, 200) }} <a href="#" id="readMoreBiography"
                            class="text-blue-500 hover:underline focus:outline-none">Read More</a>
                        <span id="fullBiography" class="hidden">{{ substr($person['biography'], 200) }}</span>
                    @else
                        {{ $person['biography'] }}
                    @endif
                </p>
                <h4 class="font-semibold mt-8 text-gray-900 dark:text-white">Known For</h4>
                <div class="overflow-x-auto mt-4 flex space-x-4">
                    @foreach ($knownForArray as $item)
                        @php
                            $route = $item['media_type'] === 'movie' ? 'movie.details' : 'series.details';
                            $idKey = $item['media_type'] === 'movie' ? 'movie_id' : 'tvID';
                        @endphp
                        <div class="flex-shrink-0">
                            <a href="{{ route($route, [$idKey => $item['id']]) }}">
                                <img src="{{ config('services.tmdb.image_base_url') . $item['poster_path'] }}"
                                    alt="poster"
                                    class="w-32 h-auto hover:opacity-75 transition ease-in-out duration-150 rounded-lg shadow-lg">
                            </a>
                            <a href="{{ route($route, [$idKey => $item['id']]) }}"
                                class="block text-sm leading-tight mt-2 text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300 whitespace-normal">
                                @php
                                    // Truncate long titles
                                    $title =
                                        strlen($item['title']) > 20
                                            ? substr($item['title'], 0, 20) . '...'
                                            : $item['title'];
                                @endphp
                                {{ $title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 dark:border-gray-600 mt-12 pt-8">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">Credits</h2>
            <ul id="creditsList" class="list-disc leading-loose pl-5 mt-4 text-gray-700 dark:text-gray-400">
                @foreach ($movies as $index => $item)
                    @if ($index < 10)
                        <li>
                            {{ $item['release_date'] }} &middot;
                            <strong>
                                <a href="" class="hover:underline">{{ $item['title'] }}</a>
                            </strong>
                            as {{ $item['character'] }}
                        </li>
                    @else
                        <li class="hidden">
                            {{ $item['release_date'] }} &middot;
                            <strong>
                                <a href="" class="hover:underline">{{ $item['title'] }}</a>
                            </strong>
                            as {{ $item['character'] }}
                        </li>
                    @endif
                @endforeach
            </ul>
            @if (count($movies) > 10)
                <button id="showMoreButton" class="text-blue-500 hover:underline focus:outline-none mt-2">
                    Show More ({{ count($movies) - 10 }} remaining)
                </button>
            @endif
        </div>
    </div>

    <div class="movie-images border-b border-gray-800 dark:border-gray-700">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold text-gray-900 dark:text-gray-100">
                <i class="fas fa-images text-blue-500 mr-2"></i> Images
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($person['images']['profiles'] as $image)
                    <div class="mt-8">
                        <img height="{{ $image['height'] }}" width="{{ $image['width'] }}"
                            src="{{ config('services.tmdb.image_base_url') . $image['file_path'] }}"
                            alt="Image was not found" srcset="" loading="lazy"
                            class="hover:opacity-75 transition ease-in-out duration-150">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('readMoreBiography').addEventListener('click', function(e) {
            e.preventDefault();
            var fullBiography = document.getElementById('fullBiography');
            var readMoreButton = this;

            fullBiography.classList.toggle('hidden');
            if (fullBiography.classList.contains('hidden')) {
                readMoreButton.textContent = 'Read More';
            } else {
                readMoreButton.textContent = 'Read Less';
            }
        });

        document.getElementById('showMoreButton').addEventListener('click', function() {
            var hiddenItems = document.querySelectorAll('#creditsList li.hidden');
            hiddenItems.forEach(function(item) {
                item.classList.toggle('hidden');
            });

            var showMoreButton = this;
            if (hiddenItems.length > 0) {
                showMoreButton.textContent = 'Show Less';
            } else {
                var allItems = document.querySelectorAll('#creditsList li');
                allItems.forEach(function(item) {
                    if (allItems.indexOf(item) >= 10) {
                        item.classList.add('hidden');
                    }
                });
                showMoreButton.textContent = 'Show More';
            }
        });
    </script>
@endsection
