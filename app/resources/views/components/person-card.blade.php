<div class="mt-8 rounded-lg bg-white dark:bg-gray-800 shadow-md overflow-hidden">
    <a href="{{ route('person.details', ['person_id' => $personID]) }}">
        <img src="{{ config('services.tmdb.image_base_url') . $image }}" alt="{{ $name }} NOT FOUND"
            class="hover:opacity-75 transition ease-in-out duration-150">
    </a>

    <div class="mt-6 px-4 py-4">
        <a class="text-lg font-semibold text-gray-900 dark:text-white hover:text-gray-300 dark:hover:text-gray-400"
            href="{{ route('person.details', ['person_id' => $personID]) }}">
            {{ $name }}
        </a>

        <div class="text-gray-400 dark:text-gray-600 mt-2">
            <p>Known For:</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($knownForArray as $item)
                    <span class="inline-block bg-gray-200 dark:bg-gray-600 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        {{ $item['title'] ?? $item['name'] }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
