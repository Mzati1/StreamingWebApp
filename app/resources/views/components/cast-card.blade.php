<div class="mt-8 rounded-md">
    <a href="#">
        <img src="{{ config('services.tmdb.image_base_url').$profileImage }}" alt="{{ $actorName }} NOT FOUND" class="hover:opacity-75 transition ease-in-out duration-150">
    </a>

    <div class="mt-6">
        <a class="text-sm mt-2 hover:text-gray-300" href="#">
            {{ $actorName }}
        </a>

        <div class="text-gray-400">
           As: {{ $characterName }}
        </div>
    </div>
</div>
