<div>
    <div class="mt-8">
        <div class="container grid grid-cols-1 lg:grid-cols-3 gap-8">  
            <div class="lg:col-span-2">
                @if ($this->current)
                    
                    @if ($this->current->platform == 2)
                        <div class="embed-responsive">
                            <iframe class="video-responsive" src="{{ $currentIframe }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        <video class="video-responsive" controls preload="metadata" wire:key="{{ $current->id }}">
                            <source src="{{ Storage::url($current->video_path) }}?t={{ time() }}" type="{{ $currentMimeType }}">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                    <h1 class="text-3xl text-gray-600 font-bold mt-4">{{ $this->current->name }}</h1>

                    <div class="text-gray-600">
                        @if ($this->current->description)
                            <p>{{ $this->current->description }}</p>
                        @else
                            <p class="italic">No existe descripción para esta lección</p>
                        @endif
                    </div>

                    <div class="flex items-center mt-4 cursor-pointer" wire:click="completed">
                        @if ($this->current->completed)
                            <i class="fas fa-toggle-on text-2xl text-blue-600"></i>
                        @else
                            <i class="fas fa-toggle-off text-2xl text-gray-600"></i>
                        @endif

                        <p class="text-sm ml-2">Marcar esta unidad como culminada</p>
                    </div>

                    <div class="card mt-2">
                        <div class="card-body flex text-gray-500 font-bold">
                            @if ($this->previous)
                                <a wire:click="changeLesson({{$this->previous->id}})" class="cursor-pointer">Tema anterior</a>
                            @endif
                            @if ($this->next)
                                <a wire:click="changeLesson({{$this->next->id}})" class="ml-auto cursor-pointer">Tema posterior</a>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-2">
                        @livewire('course-review', ['course' => $course])
                    </div>

                @else
                    <p>No hay lección actual.</p>
                @endif
            </div>

            <div class="card col-span-1">
                <div class="card-body">
                    <h1 class="text-2xl leading-8 text-center mb-4">{{ $course->title }}</h1>
                    <div class="flex items-center">
                        <figure>
                            <img class="w-12 h-12 object-cover rounded-full mr-4" src="{{ $course->teacher->profile_photo_url }}" alt="">
                        </figure>
                        <div>
                            <p>{{ $course->teacher->name }}</p>
                            <a class="text-blue-500 text-sm" href="">{{ '@' . Str::slug($course->teacher->name, '') }}</a>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mt-2">{{ $this->advance }}% completado</p>

                    <div class="relative pt-1">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                            <div style="width:{{ $this->advance }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div>
                        </div>
                    </div>
                
                    <ul>
                        @foreach ($course->sections->sortBy('position') as $section)
                            <li class="text-gray-600 mb-4">
                                <a class="font-bold text-base inline-block mb-2">{{ $section->name }}</a>
                                <ul>
                                    @foreach ($section->lessons as $lesson)
                                        <li class="flex">
                                            <div>
                                                @if($lesson->completed)
                                                    @if ($current && $current->id == $lesson->id)
                                                        <span class="inline-block w-4 h-4 border-4 border-yellow-500 rounded-full mr-2 mt-1"></span>
                                                    @else
                                                        <span class="inline-block w-4 h-4 bg-yellow-300 rounded-full mr-2 mt-1"></span>
                                                    @endif
                                                @else
                                                    @if ($current && $current->id == $lesson->id)
                                                        <span class="inline-block w-4 h-4 border-4 border-gray-500 rounded-full mr-2 mt-1"></span>
                                                    @else
                                                        <span class="inline-block w-4 h-4 bg-gray-300 rounded-full mr-2 mt-1"></span>
                                                    @endif
                                                @endif
                                            </div>
                                            <a class="cursor-pointer" wire:click="changeLesson({{ $lesson->id }})">
                                                {{ $lesson->name }}
                                            </a>
                                        </li>
                                    @endforeach    
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('render', function () {
                const video = document.querySelector('video');
                const iframe = document.querySelector('iframe');

                // Comprobamos la propiedad $cambiado
                if ({{ $cambiado }}) {
                    // Asegúrate que el video actual se ponga en pausa si está en reproducción
                    if (video) {
                        video.pause();
                        video.load(); // Forzar una recarga del video para el nuevo contenido
                    }
                    
                    // Asegúrate que el iframe recarga cambiando el atributo src
                    if (iframe) {
                        const src = iframe.src;
                        iframe.src = ''; // Cambiar a un valor vacío primero
                        iframe.src = src; // Volver a establecer la URL para recargar
                    }
                }
            });
        });
    </script>
</div>















