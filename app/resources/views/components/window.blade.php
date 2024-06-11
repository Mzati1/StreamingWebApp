<!-- resources/views/components/window.blade.php -->
<div class="relative bg-gray-200 dark:bg-gray-800 rounded-lg shadow-lg p-4">
    <img class="rounded-lg mb-4" src="{{ config('services.tmdb.image_base_url') . $poster }}" alt="{{ $title }}">
    <h3 class="text-lg font-semibold mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Genre: {{ $genre }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-400">Rating: {{ $rating }}</p>
</div>
