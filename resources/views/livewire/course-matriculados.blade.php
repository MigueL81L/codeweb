<div>
    <div class="bg-gray-200 py-4 mb-16">  
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex">
            <div class="grid grid-cols-5 gap-x-4">

                <div class="col-span-1">
                    <div class="flex items-center justify-start space-x-4">
                        <!-- Botón para resetear los filtros -->
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                wire:click="resetFilters">
                            <i class="fas fa-archway text-xs mr-2"></i>  
                            Todos los Cursos
                        </button>
                    </div>
                </div>

                <!-- Filtro por Categoría -->
                <div class="col-span-2">
                    <form wire:submit.prevent="filterCategories" class="flex items-center justify-end space-x-4">
                        <div>
                            <select wire:model="selectedCategories" id="selectedCategories" name="selectedCategories" class="h-10 border-gray-300 rounded-lg">
                                <option class="py-2" value="">Seleccione una Categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-th-list text-xs mr-2"></i>  
                            Filtrar por Categorias
                        </button>
                    </form>
                </div>

                <!-- Filtro por Nivel -->
                <div class="col-span-2">
                    <form wire:submit.prevent="filterLevels" class="flex items-center justify-end space-x-4">
                        <div>
                            <select wire:model="selectedLevels" id="selectedLevels" name="selectedLevels" class="h-10 border-gray-300 rounded-lg">
                                <option class="py-2" value="">Seleccione el Nivel</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-filter text-xs mr-2"></i>  
                            Filtrar por Niveles
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Mostrar Cursos Paginados -->
    @if($courses->isNotEmpty())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($courses as $course)
                <x-instructor.course-card :course="$course" />
            @endforeach
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
            {{ $courses->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-gray-100 rounded-lg p-4 text-center w-full">
            <p class="text-gray-500 font-bold block">{{ $mensaje }}</p> 
        </div>
    @endif
</div>

