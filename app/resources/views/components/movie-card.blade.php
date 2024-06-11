<div class="mt-8 rounded-lg bg-white dark:bg-gray-800 shadow-md overflow-hidden">
    <a href="{{ route('movie.details', ['movie_id' => $movieID]) }}">
        <img src="{{ config('services.tmdb.image_base_url') . $imageURL }}" alt="{{ $title }}"
            class="hover:opacity-75 transition ease-in-out duration-150">
    </a>

    <div class="mt-6 px-4 py-4">
        <a class="text-lg font-semibold text-gray-900 dark:text-white hover:text-gray-300 dark:hover:text-gray-400"
            href="#">
            {{ $title }}
        </a>

        <div class="flex items-center text-gray-400 dark:text-gray-600 text-sm mt-1">
            <span>⭐️</span>
            <span class="ml-1">{{ $rating }}%</span>
            <span class="mx-2">|</span>
            <span>{{ Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
        </div>

        <div class="text-gray-400 dark:text-gray-600 mt-2">
            @foreach ($genreArray as $genreId)
                <span
                    class="inline-block bg-gray-200 dark:bg-gray-600 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">{{ $genreMap[$genreId] }}
                </span>
            @endforeach
        </div>

    </div>
</div>
