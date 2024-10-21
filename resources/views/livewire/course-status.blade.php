<div>
    <div class="mt-8">
        <div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2">
                @if ($this->current) 
                    <!-- Mostrar el video/iframe de acuerdo con el método getIframeAttribute. Model Lesson.php -->
                    <!-- Contenedor que usa embed-responsive --> 
                    <div class=" w-full"> 
                        {!! $this->current->iframe !!} <!-- El iframe ahora se adaptará mejor -->
                    </div>

                    <h1 class="text-3xl text-gray-600 font-bold mt-4">{{ $this->current->name }}</h1>  

                    <div class="text-gray-600 mt-2">
                        <h2 class="font-bold">Descripción:</h2>
                        @if ($this->current->description)
                            <p>{{ $this->current->description }}</p>
                        @else
                            <p class="italic">No existe descripción para esta lección</p>
                        @endif
                    </div>

                    <div class="mt-4">
                        @if ($this->current->document_path)
                            <h2 class="font-bold">Archivo Adjunto:</h2>
                            <a href="{{ Storage::url('app/public/' . $this->current->document_path) }}" class="text-blue-500 hover:underline" target="_blank">Ver/Descargar Documento</a>
                        @else
                            <p class="italic">No hay archivos adjuntos para esta lección.</p>
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
                                <a wire:click="changeLesson({{ $this->previous->id }})" class="cursor-pointer">Tema anterior</a>
                            @endif
                            @if ($this->next)
                                <a wire:click="changeLesson({{ $this->next->id }})" class="ml-auto cursor-pointer">Tema posterior</a>
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
                        @foreach ($course->sections as $section)
                            <li class="text-gray-600 mb-4">
                                <a class="font-bold text-base inline-block mb-2">{{ $section->name }}</a>
                                <ul>
                                    @foreach ($section->lessons as $lesson)
                                        <li class="flex">
                                            <div>
                                                @if($lesson->completed)
                                                    @if ($this->current && $this->current->id == $lesson->id)
                                                        <span class="inline-block w-4 h-4 border-4 border-yellow-500 rounded-full mr-2 mt-1"></span>
                                                    @else
                                                        <span class="inline-block w-4 h-4 bg-yellow-300 rounded-full mr-2 mt-1"></span>
                                                    @endif
                                                @else
                                                    @if ($this->current && $this->current->id == $lesson->id)
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

























