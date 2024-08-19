{{-- resources/views/livewire/course-status.blade.php --}}
<div x-data="{ currentVideoKey: 0 }" @lesson-changed.window="currentVideoKey++">
    <div class="mt-8">
        <div class="container grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                
                @if ($current)
                    {{-- Comprueba la plataforma del vídeo para decidir si usar iframe o video --}}
                    @if ($current->platform == 2)
                        <div class="embed-responsive">
                            {{-- Renderiza un iframe para videos de YouTube --}}
                            <iframe class="video-responsive" src="{{ $currentIframe }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        {{-- Usa la propiedad ':key' para forzar al navegador a re-renderizar el video al cambiar, resolviendo problemas de carga de videos nuevos --}}
                        <video :key="currentVideoKey" class="video-responsive" controls>
                            <source src="{{ Storage::url($current->video_path) }}" type="{{ $currentMimeType }}">
                            Your browser does not support the video tag.
                        </video>
                    @endif

                    {{-- Título de la lección actual --}}
                    <h1 class="text-3xl text-gray-600 font-bold mt-4">{{ $current->name }}</h1>

                    {{-- Descripción de la lección actual --}}
                    <div class="text-gray-600">
                        @if ($current->description)
                            <p>{{ $current->description }}</p>
                        @else
                            <p class="italic">No existe descripción para esta lección</p>
                        @endif
                    </div>

                    {{-- Botón de completar lección, alterna el estado completado --}}
                    <div class="flex items-center mt-4 cursor-pointer" wire:click="completed">
                        @if ($current->completed)
                            <i class="fas fa-toggle-on text-2xl text-blue-600"></i>
                        @else
                            <i class="fas fa-toggle-off text-2xl text-gray-600"></i>
                        @endif
                        <p class="text-sm ml-2">Marcar esta unidad como culminada</p>
                    </div>

                    {{-- Navegación entre lecciones anteriores y siguientes --}}
                    <div class="card mt-2">
                        <div class="card-body flex text-gray-500 font-bold">
                            @if ($previous)
                                <a wire:click="changeLesson({{ $previous }})" class="cursor-pointer">Tema anterior</a>
                            @endif
                            @if ($next)
                                <a wire:click="changeLesson({{ $next }})" class="ml-auto cursor-pointer">Tema posterior</a>
                            @endif
                        </div>
                    </div>

                    {{-- Sección de revisión del curso --}}
                    <div class="card mt-2">
                        @livewire('course-review', ['course' => $course])
                    </div>
                @else
                    <p>No hay lección actual.</p>
                @endif
            </div>

            {{-- Barra lateral mostrando el progreso del curso y lista de lecciones --}}
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

                    {{-- Sección que muestra el progreso en porcentaje realizado del curso --}}
                    <p class="text-gray-600 text-sm mt-2">{{ $advance }}% completado</p>

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
</div>











