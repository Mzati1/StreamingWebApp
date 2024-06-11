<div class="form-control relative" x-data="{ isOpen: true }" @click.away="isOpen = false">
    <input wire:model.live="search" type="text" placeholder="Search"
        class="input input-bordered w-24 md:w-auto text-sm transition-all" @focus="isOpen = true"
        @keydown.escape.window="isOpen = false" @keydown.shift.tab="isOpen = false" @keydown="isOpen = true"
        @keydown="isOpen = true"
         />
    <div class="absolute top-0"></div>

    <span wire:loading class="loading loading-bars loading-sm ml-40 mt-3"></span>

    @if (strlen($search) >= 2)
        <div class="z-50 absolute bg-base-200 rounded w-64 mt-14 ml-4 max-h-96 overflow-y-auto"
            x-show.transition.opacity="isOpen" @click.away="isOpen = false">
            <ul>
                @if (empty($searchResults))
                    <div class="py-3 px-3">No results for "{{ $search }}"</div>
                @else
                    @foreach ($searchResults as $element)
                        <li class="border-b border-base-300 transition-all px-3 py-3 flex items-center">
                            @if ($element['media_type'] === 'movie')
                                <div>
                                    <a class="block hover:bg-base-300 px-3 py-3 flex items-center"
                                        href="{{ route('movie.details', ['movie_id' => $element['id']]) }}">
                                        @if (isset($element['poster_path']))
                                            <img class="w-10"
                                                src="{{ config('services.tmdb.image_base_url') . $element['poster_path'] }}"
                                                alt="{{ $element['title'] }}" class="mr-2">
                                        @else
                                            <img class="w-10" src="https://placehold.co/50x75" class="mr-2">
                                        @endif
                                        <span class="ml-4">{{ $element['title'] }}</span>
                                    </a>
                                </div>
                            @elseif ($element['media_type'] === 'tv')
                                <div>
                                    <a class="block hover:bg-base-300 px-3 py-3 flex items-center"
                                        href="{{ route('serie.details', ['tvID' => $element['id']]) }}">
                                        @if (isset($element['poster_path']))
                                            <img class="w-10"
                                                src="{{ config('services.tmdb.image_base_url') . $element['poster_path'] }}"
                                                alt="{{ $element['name'] }}" class="mr-2">
                                        @else
                                            <img class="w-10" src="https://placehold.co/50x75" class="mr-2">
                                        @endif
                                        <span class="ml-4">{{ $element['name'] }}</span>
                                    </a>
                                </div>
                            @elseif ($element['media_type'] === 'person')
                                <div>
                                    <a class="block hover:bg-base-300 px-3 py-3 flex items-center"
                                        href="{{ route('person.details', ['person_id' => $element['id']]) }}">
                                        @if (isset($element['profile_path']))
                                            <img class="w-10"
                                                src="{{ config('services.tmdb.image_base_url') . $element['profile_path'] }}"
                                                alt="{{ $element['name'] }}" class="mr-2">
                                        @else
                                            <img class="w-10" src="https://placehold.co/50x75" class="mr-2">
                                        @endif
                                        <span class="ml-4">{{ $element['name'] }}</span>
                                    </a>
                                </div>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    @endif
</div>
