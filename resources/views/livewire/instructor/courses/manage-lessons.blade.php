@php
    // Defino las variables
    $platformName = "";
    $urlVideo = "";
@endphp

<div>
    <div x-data="{
        destroyLesson(lessonId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',  
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡elimínalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', lessonId);
                }
            });
        }
    }"
    class="mb-6"
    x-init="Sortable.create($refs.lessonList, {
        group: 'lessons',
        animation: 150,
        handle: '.handle',
        onEnd: function (evt) {
           let order = Array.from(evt.from.children).map(child => child.dataset.id)
           @this.call('sortLessons', order)
        }
    })"
    >
        <ul class="space-y-4" x-ref="lessonList">
            @foreach ($lessons as $lesson)
                <li wire:key="lesson-{{$lesson->id}}" data-id="{{$lesson->id}}">
                    <div x-data="{ isOpen: false }" class="bg-white rounded-lg shadow-lg px-6 py-4 handle" style="cursor: move;">
                        @if ($lessonEdit['id'] == $lesson->id)
                            <form wire:submit.prevent="update">
                                <div class="flex items-center space-x-2">
                                    <x-label>
                                        {{-- Variable propia del bucle foreach, que indica la iteración en la que se encuentra --}}
                                        Lección {{$loop->iteration}}:
                                    </x-label>
                                    <x-input wire:model="lessonEdit.name" class="flex-1" />
                                </div>
                                <div class="mt-2">
                                    <x-label>Descripción</x-label>
                                    <x-textarea wire:model="lessonEdit.description" class="w-full" />
                                </div>
                                <div class="flex justify-end mt-4">
                                    <div class="space-x-2">
                                        <x-danger-button wire:click="$set('lessonEdit.id', null)">
                                            Cancelar
                                        </x-danger-button>
                                        <x-button>
                                            Actualizar
                                        </x-button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="md:flex md:items-center mt-2">
                                <h1 class="md:flex-1 truncate cursor-move">
                                    <i class="fas fa-play-circle text-blue-600"></i>
                                    {{--
                                        $orderLessons es un array con los id de todas las lecciones
                                        de un curso; a la posición en el array se le suma 1 para dar la posición
                                    --}}
                                    Lección {{$orderLessons->search($lesson->id) + 1}}: 
                                    {{$lesson->name}}
                                </h1>
                                <div class="space-x-2 md:shrink-0 md:ml-4">
                                    <button wire:click="edit({{$lesson->id}})">
                                        <i class="fas fa-edit hover:text-indigo-600"></i>
                                    </button>
                                    <button x-on:click="destroyLesson({{$lesson->id}})">
                                        <i class="far fa-trash-alt hover:text-red-600"></i>
                                    </button>
                                    {{-- Botón para abrir/cerrar acordeón --}}
                                    <button x-on:click="isOpen = !isOpen">
                                        <i class="fas fa-chevron-down hover:text-blue-600" :class="{'transform rotate-180': isOpen}"></i>
                                    </button>
                                </div>
                            </div>
                            <hr>
                            @php
                                if ($lesson->platform == 1) {
                                    $platformName = "Video Convencional";
                                    $urlVideo = Storage::url($lesson->video_path);
                                } elseif ($lesson->platform == 2) {
                                    $platformName = "Video Youtube";
                                    $urlVideo = $lesson->video_original_name;
                                } else {
                                    $platformName = "N/A";
                                    $urlVideo = "N/A";
                                }
                            @endphp
                            {{-- Contenido del acordeón --}}
                            <div x-show="isOpen" x-cloak>
                                <p class="text-sm">Plataforma: {{$platformName}}</p>
                                <p class="text-sm">Enlace: <a class="text-blue-600" href="{{ $urlVideo }}">{{$lesson->video_original_name}}</a></p>                                
                                <p class="text-sm ">Descripción: </p>
                                <hr>
                                @if ($lesson->description)
                                    <p class="txt-sm">{{$lesson->description}}</p>
                                @else
                                    <p class="txt-sm">No existe descripción para esta lección</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Creación --}}
    {{-- Inicializo Alpine.js, defino dos variables que enlazo con la propiedad lessonCreate del controlador Livewire --}}
    <div x-data="{ open:@entangle('lessonCreate.open'), platform:@entangle('lessonCreate.platform') }">
        <div x-on:click="open = !open"
            class="h-6 w-12 -ml-4 bg-indigo-200 hover:bg-indigo-300 flex items-center justify-center cursor-pointer"
            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">
            <i class="-ml-2 text-sm fas fa-plus transition duration-300"
                :class="{ 'transform rotate-45': open, 'transform rotate-0': !open }"></i>
        </div>
        <form wire:submit.prevent="store" class="mt-4 bg-white rounded-lg shadow-lg"
            x-show="open" x-cloak>
            <div class="p-6">
                <div class="mb-2">
                    <x-input wire:model="lessonCreate.name" class="w-full" placeholder="Ingrese el nombre de la Lección" />
                    <x-input-error for="lessonCreate.name" />
                </div>
                <div>
                    <x-label class="mb-1">Plataformas</x-label>
                    <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                            <button type="button" class="inline-flex flex-col justify-center items-center w-full md:w-20 h-24 border rounded"
                                :class="platform == 1 ? 'border-indigo-500 text-indigo-500':'border-gray-300'"
                                x-on:click="platform = 1">
                                <i class="fas fa-video text-2xl"></i>
                                <span class="text-sm mt-2">Video</span>
                            </button>
                            <button type="button" class="inline-flex flex-col justify-center items-center w-full md:w-20 h-24 border rounded"
                                :class="platform == 2 ? 'border-indigo-500 text-indigo-500':'border-gray-300'"
                                x-on:click="platform = 2">
                                <i class="fab fa-youtube text-2xl"></i>
                                <span class="text-sm mt-2">Youtube</span>
                            </button>
                        </div>
                        <p>Primero debes elegir una plataforma para subir tu contenido</p>
                    </div>
                    <div class="mt-2" x-show="platform == 1" x-cloak>
                        <x-label>Video</x-label>
                        {{-- Componente creado para mostrar barra de progreso --}}
                        <x-progress-indicators wire:model="video" />
                        <x-input-error for="video" />
                    </div>
                    <div class="mt-2" x-show="platform == 2" x-cloak>
                        <x-label>Video Youtube</x-label>
                        <x-input wire:model="url" placeholder="Ingrese la URL de Youtube" class="w-full" />
                        <x-input-error for="url" />  
                    </div>
                </div>
            </div>
            <div class="flex justify-end px-6 py-4 bg-gray-100">
                <x-danger-button x-on:click="open = false">Cancelar</x-danger-button>
                <x-button class="ml-2">Guardar</x-button>
            </div>
        </form>
    </div>
</div> 




