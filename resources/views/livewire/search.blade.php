<form  class="pt-2 relative mx-auto text-gray-600" autocomplete="off">
    <input wire:model.live="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
           type="search" name="search" placeholder="Search">

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded absolute right-0 top-0 mt-2">
        Reset
    </button>

    @if ($search != "")
        <ul class="absolute z-50 left-0 w-full bg-white mt-1 rounded-lg overflow-hidden">
            @forelse ($results as $result)
                <li class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                    <!-- Envolvemos el contenido del li con el enlace -->
                    <a href="{{ route('courses.show', $result) }}" class="block w-full h-full">
                        {{ $result->title }}
                    </a>
                </li>
            @empty
                <li class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                    Ninguna coincidencia encontrada :(
                </li>
            @endforelse
        </ul>
    @endif
</form>












