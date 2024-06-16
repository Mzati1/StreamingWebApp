@extends('components.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <!-- Media Player Section -->
        <div class="relative mb-8">
            <div id="media-player" class="bg-black rounded-lg shadow-lg overflow-hidden" style="padding-top: 56.25%;">
                <!-- Default image -->
                <img id="default-image" src="{{ config('services.tmdb.image_base_url') . $tvShow['backdrop_path'] }}"
                    alt="Default Image"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-opacity duration-500">

                <!-- Embedded video player -->
                <iframe id="video-player" src="" class="absolute top-0 left-0 w-full h-full" referrerpolicy="origin"
                    allowfullscreen></iframe>
            </div>
        </div>

        <!-- TV Show Information Section -->
        <div class="lg:flex lg:gap-8 mb-8">
            <div class="lg:w-1/3">
                <img src="{{ config('services.tmdb.image_base_url') . $tvShow['poster_path'] }}" alt="Poster Image"
                    class="rounded-lg shadow-lg mb-4 lg:mb-0">
            </div>
            <div class="lg:w-2/3 space-y-4 lg:pl-8">
                <h2 class="text-3xl font-bold">{{ $tvShow['name'] }}</h2>
                <div class="text-xl italic text-gray-700 dark:text-gray-300">{{ $tvShow['tagline'] }}</div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tvShow['genres'] as $genre)
                        <span class="badge badge-primary">{{ $genre['name'] }}</span>
                    @endforeach
                </div>
                <p class="text-gray-700 dark:text-gray-300">{{ $tvShow['overview'] }}</p>
                <div class="flex items-center gap-4">
                    <div>
                        <span class="font-bold">Rating:</span> {{ $tvShow['vote_average'] * 10 }} %
                    </div>
                    <div>
                        <span class="font-bold">Votes:</span> {{ $tvShow['vote_count'] }}
                    </div>
                </div>
                <div class="space-y-2">
                    <div><span class="font-bold">Type:</span> TV</div>
                    <div><span class="font-bold">Country:</span> {{ $tvShow['production_countries'][0]['name'] }}</div>
                    <div><span class="font-bold">Release:</span> {{ $tvShow['first_air_date'] }} </div>
                    <div><span class="font-bold">Status:</span> {{ $tvShow['status'] }}</div>
                    <div><span class="font-bold">Created By:</span> {{ $tvShow['created_by'][0]['name'] }}</div>
                    <div>
                        <span class="font-bold text-lg">Production:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($tvShow['production_companies'] as $item)
                                <span class="badge badge-primary">{{ $item['name'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seasons and Episodes Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Seasons</h2>
            <div class="flex flex-col lg:flex-row lg:items-center lg:gap-4">
                <select id="season-select" class="select select-bordered w-full max-w-xs mb-4 lg:mb-0">
                    <option value="" disabled selected>Select a season</option>
                    @foreach ($tvShow['seasons'] as $season)
                        <option value="{{ $season['season_number'] }}">{{ $season['name'] }}</option>
                    @endforeach
                </select>
                <div id="episodes-section" class="hidden w-full">
                    <h3 class="text-xl font-bold mb-4">Episodes</h3>
                    <div id="episode-buttons" class="flex flex-wrap gap-4"></div>
                </div>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div>
            <h2 class="text-2xl font-bold mb-4">Recommended Series</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($recommendations as $series)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ config('services.tmdb.image_base_url') . $series['poster_path'] }}" alt="Poster Image"
                            class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold">{{ $series['name'] }}</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ Str::limit($series['overview'], 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoPlayer = document.getElementById('video-player');
            const defaultImage = document.getElementById('default-image');
            const seasonSelect = document.getElementById('season-select');
            const episodeButtonsContainer = document.getElementById('episode-buttons');
            const episodesSection = document.getElementById('episodes-section');

            const tvshow = @json($tvShow);
            const seasons = @json($tvShow['seasons']);

            // Function to populate episodes based on selected season
            function populateEpisodes(episodes) {
                episodeButtonsContainer.innerHTML = ''; // Clear previous episode buttons

                episodes.forEach((episode) => {
                    const episodeButton = document.createElement('button');
                    episodeButton.className = 'btn btn-outline btn-sm flex items-center justify-center';
                    episodeButton.textContent = `Episode ${episode.episode_number}: ${episode.name}`;
                    episodeButton.addEventListener('click', function() {
                        playEpisode(episode); // Call playEpisode function when clicked
                    });
                    episodeButtonsContainer.appendChild(episodeButton); // Append button to container
                });

                episodesSection.classList.remove('hidden'); // Show episodes section
            }

            // Function to play the selected episode
            function playEpisode(episode) {
                const videoUrl =
                    `https://vidsrc.me/embed/tv?imdb=${tvshow.external_ids.imdb_id}&season=${episode.season_number}&episode=${episode.episode_number}`;
                console.log('Video URL:', videoUrl);
                videoPlayer.src = videoUrl; // Set iframe source
                localStorage.setItem('lastPlayedEpisode', JSON.stringify(
                    episode)); // Save last played episode in localStorage

                // Show the video player and hide the default image
                defaultImage.classList.add('opacity-0');
                setTimeout(() => {
                    defaultImage.style.display = 'none';
                }, 500);
            }

            // Function to load the last played episode or the first episode of the first season
            function loadLastPlayedEpisodeOrFirst() {
                const lastPlayedEpisode = localStorage.getItem('lastPlayedEpisode');
                let episodeToPlay;

                if (lastPlayedEpisode) {
                    episodeToPlay = JSON.parse(lastPlayedEpisode);
                } else if (seasons.length > 0 && seasons[0].episodes.length > 0) {
                    episodeToPlay = seasons[0].episodes[0];
                }

                if (episodeToPlay) {
                    const selectedSeason = seasons.find(season => season.season_number == episodeToPlay
                        .season_number);
                    if (selectedSeason) {
                        populateEpisodes(selectedSeason.episodes); // Populate episodes for selected season
                        seasonSelect.value = selectedSeason.season_number; // Set season select to the correct value
                        playEpisode(episodeToPlay); // Play the episode
                    }
                }
            }

            // Event listener for season selection change
            seasonSelect.addEventListener('change', function() {
                const selectedSeasonNumber = this.value;
                const selectedSeason = seasons.find(season => season.season_number == selectedSeasonNumber);

                if (selectedSeason) {
                    populateEpisodes(selectedSeason.episodes); // Populate episodes for selected season
                }
            });

            // Load the last played episode or the first episode of the first season on document load
            loadLastPlayedEpisodeOrFirst();
        });
    </script>
@endsection
