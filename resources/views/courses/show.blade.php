<x-app-layout>
    <section class="bg-gray-700 py-12 mb-12">
        <div class="container grid grid-cols-1 lg:grid-cols-2 gap-6">
            <figure>
                <img class="h-60 w-full object-cover" src="{{$course->image}}" alt="">
            </figure>

            <div class="text-white flex flex-col items-center mx-auto">
                <h1 class="text-3xl mb-3">{{$course->title}}</h1>
                <div class="flex items-center mb-2">
                    <i class="fas fa-chart-line mr-2"></i>
                    <p>Nivel: {{$course->level->name}}</p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fas fa-tags mr-2"></i>
                    <p>Categoría: {{$course->category->name}}</p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fas fa-users mr-2"></i>
                    <p>Matriculados: {{$course->students_count}}</p>
                </div>
                <div class="flex items-center">
                    <i class="far fa-star mr-2"></i>
                    <p>
                        Calificación:
                        @if ($course->reviews_count > 0)
                            {{ $course->rating }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
            
        </div>
    </section>

    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-6"> 
        <div class="order-2 lg:col-span-2 lg:order-1">
            <section class="card mb-12">
                <div class="card-body">
                    <h1 class="font-bold text-2xl mb-2 text-center sm:text-left">Lo que Aprenderás:</h1>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 ">
                        @foreach ($course->goals as $goal)
                            <li class="text-gray-700 text-base"><i class="fas fa-check text-gray-600 mr-2"></i>{{$goal->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <!--Hay que crear las lessons y sections-->
            <section class="card mb-12">
                <h1 class="font-bold text-3xl mb-2 text-center sm:text-left">Temario</h1>

                @foreach ($course->sections as $section)
                    <article class="mb-4 shadow" 
                        {{--loop->first es un modo de preguntar si el bucle está en la primera iteration--}}
                        @if($loop->first)
                        {{--La primera sección estará abierta, el resto cerradas hasta que el usuario las clicke--}}
                            x-data="{open:true}"
                        @else
                        x-data="{open:false}"
                        @endif>
                        <header class="border border-gray-200 px-4 py-2 cursor-pointer bg-200"
                        x-on:click="open=!open">
                            <h1 class="font-bold text-lg text-gray-600 text-center sm:text-left">{{$section->name}}</h1>
                        </header>
                        <div class="bg-white py-2 px-4" x-show="open">
                            <ul class="grid grid-cols-1 gap-2">
                                @foreach ($section->lessons as $lesson)
                                    <li class="text-gray-700 text-base"><i class="fas fa-play-circle mr-2 text-gray-600"></i>{{$lesson->name}}</li>
                                @endforeach
                            </ul>
                        </div> 

                    </article>
                @endforeach
            </section>

            <section class="card mb-12">
                <h1 class="font-bold text-3xl mb-2 text-center sm:text-left">Requisitos</h1>
                <ul class="list-disc list-inside">
                    @foreach ($course->requirements as $requirement)
                        <li class="text-gray-700 text-base">{{$requirement->name}}</li>
                    @endforeach 
                </ul>
            </section>

            <section class="card mb-12">
                <h1 class="font-bold text-3xl mb-2 text-center sm:text-left">Descripción</h1> 
                <div class="text-gray-700 text-base">
                    <p class="text-gray-700 text-base">{{$course->description}}</p>
                
                    @if($course->description==null)
                    <p class="text-gray-700 text-base text-center sm:text-left">No hay descripción del curso, todavía.</p>
                    @endif
                </div>
            </section>

            <section class="card mb-12">
                <h1 class="font-bold text-3xl mb-2 text-center sm:text-left">Reseñas</h1>
                <p class="text-gray-700 text-base mb-2 ">Número de estudiantes matriculados: <strong>{{ $course->students_count }}</strong></p>
                <p class="text-gray-700 text-base mb-2 ">
                    Puntuación media: 
                    <strong>
                        @if ($course->reviews_count > 0)
                            {{ $course->rating }}
                        @else
                            N/A
                        @endif
                    </strong>
                </p>
            
                <h2 class="font-bold text-2xl mt-4 mb-2 text-center sm:text-left">Últimas Reseñas</h2>
                <div class="space-y-4">
                    @foreach($recentReviews as $review)
                        <div class="bg-white p-4 rounded-lg shadow-md w-full">
                            <p class="font-bold text-center sm:text-left">{{ $review->user->name }} </p>
                            <p><span class="text-sm text-gray-500 text-center sm:text-left">(Calificación: <strong>{{ $review->rating }}</strong>)</span></p>
                            <p class="text-gray-700 text-sm truncate text-left">{{ $review->comment }}</p>
                            <button class="text-blue-500 text-xs text-center sm:text-left" onclick="this.previousElementSibling.classList.toggle('truncate'); this.classList.toggle('hidden')">Leer más</button>
                        </div>
                    @endforeach
                </div>

                @if($recentReviews->isEmpty())
                    <p class="text-gray-700 text-base text-center sm:text-left">No hay reseñas todavía.</p>
                @endif
            </section>
            

        </div>

        <div class="order-1 lg:order-2">
            <section class="card mb-4">
                <div class="card-body">

                    <div class="flex items-center"> 

                        @if ($course->teacher->profile_photo_path)
                            <img src="{{ asset('storage/app/public/' . $course->teacher->profile_photo_path) }}" alt="{{$course->teacher->name}}" class="rounded-full h-20 w-20 object-cover shadow-lg">
                        @else
                            <div class="h-20 w-20 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="font-semibold text-gray-600">{{ strtoupper(substr($course->teacher->name, 0, 1)) }}</span>
                            </div>
                        @endif


                        <div class="ml-4">
                            <h1 class="font-bold text-gray-500">Prof. {{$course->teacher->name}}</h1>
                            <a class="text-blue-400 text-sm font-bold" href="mailto:{{$course->teacher->email}}">{{'@'. Str::slug($course->teacher->name, '')}}</a>
                        </div>
                    </div>

                    <div class="mt-2"> 
                        <!--Policy CoursePolicy, método enrolled-->
                        @can('enrolled', $course)
                            <p class="flex items-center mb-1">
                                <svg class="fill-current h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-6h2v6zm0-8h-2V7h2v4z"/>
                                </svg>
                                
                                <span class="font-semibold">
                                    @if($date = $course->dateOfAcquisition())
                                        Adquirido el {{ $date->format('d/m/Y') }}
                                    @else
                                        Fecha de adquisición no disponible
                                    @endif
                                </span>
                            </p>
                            <a class="btn btn-danger btn-block mt-4 mb-2" href="{{route('courses.status', $course)}}">
                                Continuar con el curso
                            </a>
                        @else
                            <!--LLamada al componenete carrito de la compra y sus botones-->
                            <!--Deberían sustituir al "LLevar este curso", deberían tener el precio encima-->
                            
                            @if ($course->price->value==0)
                                <h1 class="font-bold text-gray-500 text-2xl mb-2">Curso Gratuito</h1>
                            @else
                                <h1 class="font-bold text-gray-500 text-2xl mb-2">{{$course->price->value}} €</h1>
                            @endif

                            @livewire('course-enrolled', ['course' => $course])

                        @endcan
                    </div>
                </div>
            </section>

            <aside class="hidden lg:block mb-4 bg-white shadow-lg rounded overflow-hidden">
                <h1 class="font-bold text-3xl mb-4 text-center mt-2">Cursos Similares</h1>
                @if ($similares->count()!=0)
                    @foreach ($similares as $similar)
                        {{-- <article class="flex mb-6">
                            <img class="h-32 w-40 object-cover ml-4" src="{{$similar->image}}" alt="">

                            <div class="ml-3">
                                <h1 class="font-bold text-black-500">{{ Str::limit($similar->title, 30) }}</h1>
                                

                                <div class="flex items-center mb-2 mt-2">
                                    @if ($similar->teacher->profile_photo_path)
                                        <img src="{{ asset('storage/app/public/' . $similar->teacher->profile_photo_path) }}" alt="{{$similar->teacher->name}}" class="rounded-full h-20 w-20 object-cover shadow-lg">
                                    @else
                                        <div class="h-20 w-20 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="font-semibold text-gray-600">{{ strtoupper(substr($similar->teacher->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <p class="text-gray-700 text-sm ml-2">Prof. {{$similar->teacher->name}}</p>
                                </div>

                                @if ($similar->reviews_count > 0)
                                    <p class="text-sm"><i class="fas fa-star mr-2 text-yellow-400">{{" " . $similar->rating}}</i></p>
                                @else
                                    <p class="text-gray-500 text-sm mr-1">Sin reseñas</p>
                                @endif

                                <a href="{{ route('courses.show', $similar) }}" class="btn-block mt-4 btn btn-primary">
                                    Ir al Curso
                                </a>  
                            </div>
                        </article> --}}

                        <article class="flex mb-6">
                            <div class="w-full">
                                <figure class="h-32 w-40">
                                    <img class="h-full w-full object-cover" src="{{ $similar->image }}" alt="">
                                </figure>
                            
                                <div class="ml-3 flex flex-col justify-between">
                                    <h1 class="font-bold text-black-500">{{ Str::limit($similar->title, 30) }}</h1>
                            
                                    <div class="flex items-center mb-2 mt-2">
                                        @if ($similar->teacher->profile_photo_path)
                                            <img src="{{ asset('storage/app/public/' . $similar->teacher->profile_photo_path) }}" alt="{{ $similar->teacher->name }}" class="rounded-full h-10 w-10 object-cover shadow-lg">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="font-semibold text-gray-600">{{ strtoupper(substr($similar->teacher->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <p class="text-gray-700 text-sm ml-2">Prof. {{ $similar->teacher->name }}</p>
                                    </div>
                            
                                    @if ($similar->reviews_count > 0)
                                        <p class="text-sm"><i class="fas fa-star mr-2 text-yellow-400">{{ " " . $similar->rating }}</i></p>
                                    @else
                                        <p class="text-gray-500 text-sm mr-1">Sin reseñas</p>
                                    @endif
                                </div>
                            </div>
                        
                            <!-- Botón "Ir al Curso" en un bloque independiente -->
                            <div class="mt-4 w-full">
                                <button type="button" onclick="window.location='{{ route('courses.show', $similar)}}'"  class="btn btn-blue w-full uppercase mb-4">
                                    Ir al curso
                                </button>
                            </div>
                            
                        </article>
                    @endforeach
                @else
                    <p class="text-gray-700 text-base text-center mb-4">En este momento, no hay cursos similares a este</p>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>