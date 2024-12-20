<div>
    <div class="bg-gray-200 py-4 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between lg:py-4">
    
                <!-- Filtro por Categoría -->
                <div class="flex flex-col items-center w-1/3 px-2">
                    <form wire:submit.prevent="filterCategories" class="flex flex-col items-center space-y-2 lg:justify-center">
                        <div class="flex-grow w-full">
                            <select wire:model="selectedCategories" id="selectedCategories" name="selectedCategories" class="h-10 w-full border-gray-300 rounded-lg text-xs sm:text-sm md:text-base lg:text-lg text-center">
                                <option class="py-2" value="">Seleccione una Categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            <i class="fas fa-th-list text-xs mr-2"></i> 
                            Filtrar
                        </button>

                        <button type="button" wire:click="resetCategory" class="btn btn-danger btn-block mt-2">
                            <i class="fas fa-th-list text-xs mr-2"></i>
                            Reset
                        </button>
                    </form>
                </div>
    
                <!-- Filtro por Precio -->
                <div class="flex flex-col items-center w-1/3 px-2">
                    <form wire:submit.prevent="filterPrices" class="flex flex-col items-center space-y-2 lg:justify-center">
                        <div class="flex-grow w-full">
                            <select wire:model="selectedPrices" id="selectedPrices" name="selectedPrices" class="h-10 w-full border-gray-300 rounded-lg text-xs sm:text-sm md:text-base lg:text-lg text-center">
                                <option class="py-2" value="">Seleccione un Precio</option>
                                @foreach($prices as $price)
                                    <option value="{{$price->id}}">{{$price->value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            <i class="fas fa-euro-sign text-xs mr-2"></i>
                            Filtrar
                        </button>

                        <button type="button" wire:click="resetPrice" class="btn btn-danger btn-block mt-2">
                            <i class="fas fa-euro-sign text-xs mr-2"></i>
                            Reset
                        </button>
                    </form>
                </div>
    
                <!-- Filtro por Nivel -->
                <div class="flex flex-col items-center w-1/3 px-2">
                    <form wire:submit.prevent="filterLevels" class="flex flex-col items-center space-y-2 lg:justify-center">
                        <div class="flex-grow w-full">
                            <select wire:model="selectedLevels" id="selectedLevels" name="selectedLevels" class="h-10 w-full border-gray-300 rounded-lg text-xs sm:text-sm md:text-base lg:text-lg text-center">
                                <option class="py-2" value="">Seleccione el Nivel</option>
                                @foreach($levels as $level)
                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            <i class="fas fa-filter text-xs mr-2"></i>
                            Filtrar
                        </button>

                        <button type="button" wire:click="resetLevel" class="btn btn-danger btn-block mt-2">
                            <i class="fas fa-filter text-xs mr-2"></i>
                            Reset
                        </button>
                    </form>
                </div>
    
            </div>
        </div>
    </div>

    <!-- Mostrar la colección total paginada, y las filtradas no paginadas -->
    @if($courses->isNotEmpty())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($courses as $course)
                <x-instructor.course-card :course="$course" />
            @endforeach
        </div>

        @unless($isFiltered) <!--Mostrar paginación solo si la colección, no está filtrada-->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
                {{ $courses->links('pagination::tailwind') }}
            </div>
        @endunless

    @else
        <div class="bg-gray-100 rounded-lg p-4 text-center w-full">
            <p class="text-gray-500 font-bold block text-xl">{{ $mensaje }}</p>
        </div>
    @endif

</div>

















