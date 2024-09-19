<div>

    <!-- Mensaje de error -->
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div x-data="{ destroyLesson(lessonId) { Swal.fire({ title: '¿Estás seguro?', text: '¡No podrás revertir esto!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Sí, ¡elimínalo!', cancelButtonText: 'Cancelar' }).then((result) => { if (result.isConfirmed) { @this.call('destroy', lessonId); } }); } }" class="mb-6" x-init="Sortable.create($refs.lessonList, { group: 'lessons', animation: 150, handle: '.handle', onEnd: function (evt) { let order = Array.from(evt.from.children).map(child => child.dataset.id) @this.call('sortLessons', order) } })">
        <ul class="space-y-6" x-ref="lessonList">
            @foreach ($lessons as $lesson)
                <li wire:key="lesson-{{$lesson->id}}" data-id="{{$lesson->id}}">
                    <div x-data="{ isOpen: false }" class="bg-white rounded-lg shadow-lg px-6 py-4 handle mb-4" style="cursor: move;">
                        @if ($lessonEdit['id'] == $lesson->id)
                            <form wire:submit.prevent="update">
                                <div class="flex items-center space-x-2">
                                    <x-label>Lección {{$loop->iteration}}:</x-label>
                                    <x-input wire:model="lessonEdit.name" class="flex-1" />
                                </div>
                                <div class="mt-2">
                                    <x-label>Descripción</x-label>
                                    <x-textarea wire:model="lessonEdit.description" class="w-full" />
                                </div>
                                <div class="mt-2">
                                    <x-label>Documento Actual</x-label>
                                    <p>{{ $lessonEdit['document_original_name'] ?? 'No hay documento adjunto' }}</p>
                                    <x-label>Reemplazar Documento (PDF)</x-label>
                                    <x-input type="file" wire:model="lessonEdit.document" accept=".pdf" class="w-full" />
                                    <x-input-error for="lessonEdit.document" />
                                </div>
                                <div class="mt-2">
                                    <x-label>Video Actual</x-label>
                                    <p>{{ $lesson->platform == 1 ? $lesson->video_original_name : ($lesson->platform == 2 ? 'YouTube URL: ' . $lesson->video_original_name : 'No hay video adjunto') }}</p>
                                </div>
                                <div class="mt-2">
                                    @if($lesson->platform == 1)
                                        <x-label>Video</x-label>
                                        <x-input type="file" wire:model="lessonEdit.video" accept="video/*" class="w-full" />
                                        <x-input-error for="lessonEdit.video" />
                                    @elseif($lesson->platform == 2)
                                        <x-label>Video YouTube</x-label>
                                        <x-input wire:model="lessonEdit.url" placeholder="Ingrese la URL de YouTube" class="w-full" />
                                        <x-input-error for="lessonEdit.url" />  
                                    @endif
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-danger-button wire:click="$set('lessonEdit.id', null)">
                                        Cancelar
                                    </x-danger-button>
                                    <div class="ml-2">
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
                                    Lección {{$loop->iteration}}: {{$lesson->name}}
                                </h1>
                                <div class="space-x-2 md:shrink-0 md:ml-4">
                                    <button wire:click="edit({{$lesson->id}})">
                                        <i class="fas fa-edit hover:text-indigo-600"></i>
                                    </button>
                                    <button x-on:click="destroyLesson({{$lesson->id}})">
                                        <i class="far fa-trash-alt hover:text-red-600"></i>
                                    </button>
                                    <button x-on:click="isOpen = !isOpen">
                                        <i class="fas fa-chevron-down hover:text-blue-600" :class="{'transform rotate-180': isOpen}"></i>
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div x-show="isOpen" x-transition x-cloak>
                                <p class="text-sm">Descripción: {{$lesson->description ?? 'No existe descripción para esta lección'}}</p>
                                @if($lesson->document_path)
                                    <p class="text-sm">
                                        Documento: 
                                        <a href="{{ Storage::url($lesson->document_path) }}" class="text-blue-600" target="_blank">
                                            {{ $lesson->document_original_name }}
                                        </a>
                                    </p>
                                @else
                                    <p class="text-sm">No hay documento adjunto para esta lección.</p>
                                @endif
                                <p class="text-sm">
                                    Video: 
                                    @if($lesson->platform == 1 && $lesson->video_path)
                                        <a href="{{ Storage::url($lesson->video_path) }}" class="text-blue-600" target="_blank">
                                            {{ $lesson->video_original_name }}
                                        </a>
                                    @elseif($lesson->platform == 2)
                                        <a href="{{ $lesson->video_original_name }}" class="text-blue-600" target="_blank">
                                            Ver en YouTube
                                        </a>
                                    @else
                                        No hay video adjunto para esta lección.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Componente para creación de nuevas lecciones -->
    <div x-data="{ open:@entangle('lessonCreate.open'), platform:@entangle('lessonCreate.platform') }">
        <div x-on:click="open = !open" class="h-6 w-12 -ml-4 bg-indigo-200 hover:bg-indigo-300 flex items-center justify-center cursor-pointer" style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">
            <i class="-ml-2 text-sm fas fa-plus transition duration-300" :class="{ 'transform rotate-45': open, 'transform rotate-0': !open }"></i>
        </div>
        <form wire:submit.prevent="store" class="mt-4 bg-white rounded-lg shadow-lg" x-show="open" x-transition x-cloak enctype="multipart/form-data">
            <div class="p-6">

                <div class="mb-2">
                    <x-label>Nombre</x-label>
                    <x-input wire:model="lessonCreate.name" class="w-full" placeholder="Ingrese el nombre de la Lección" />
                    <x-input-error for="lessonCreate.name" />
                </div>
                <div class="mt-2">
                    <x-label>Descripción</x-label>
                    <x-textarea wire:model="lessonCreate.description" class="w-full" placeholder="Ingrese la descripción de la lección" />
                    <x-input-error for="lessonCreate.description" />  
                </div>
                <div class="mt-2">
                    <x-label>Documento (PDF)</x-label>
                    <x-input type="file" wire:model="lessonCreate.document" accept=".pdf" class="w-full" />
                    <x-input-error for="lessonCreate.document" />
                </div>

                <div class="mt-2">
                    <x-label class="mb-1">Plataformas</x-label>  
                    <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <button type="button" class="inline-flex flex-col justify-center items-center w-full md:w-20 h-24 border rounded" :class="platform == 1 ? 'border-indigo-500 text-indigo-500':'border-gray-300'" x-on:click="platform = 1">
                            <i class="fas fa-video text-2xl"></i>
                            <span class="text-sm mt-2">Video</span>
                        </button>
                        <button type="button" class="inline-flex flex-col justify-center items-center w-full md:w-20 h-24 border rounded" :class="platform == 2 ? 'border-indigo-500 text-indigo-500':'border-gray-300'" x-on:click="platform = 2">
                            <i class="fab fa-youtube text-2xl"></i>
                            <span class="text-sm mt-2">Youtube</span>
                        </button>
                    </div>
                    <div class="mt-2" x-show="platform == 1" x-cloak>
                        <x-label>Video</x-label>
                        <x-input type="file" wire:model="lessonCreate.video" accept="video/*" class="w-full" />
                        <x-input-error for="lessonCreate.video" />
                    </div>
                    <div class="mt-2" x-show="platform == 2" x-cloak>
                        <x-label>Video YouTube</x-label>
                        <x-input wire:model="lessonCreate.url" placeholder="Ingrese la URL de YouTube" class="w-full" />
                        <x-input-error for="lessonCreate.url" />  
                    </div>
                </div>

            </div>

            <div class="flex justify-end px-6 py-4 bg-gray-100">
                <x-danger-button x-on:click="open = false">Cancelar</x-danger-button>
                <div class="ml-2">
                    {{-- <x-button>Guardar</x-button> --}}
                    <x-button wire:click="store" x-bind:disabled="(platform == 1 && !lessonCreate.video) || (platform == 2 && !lessonCreate.url)">Guardar</x-button>

                </div>
            </div>
        </form>
    </div>

    <!-- Notificaciones -->
    <script>
        window.addEventListener('notify', event => {
            alert(event.detail.message);
        });
    </script>
</div>







































