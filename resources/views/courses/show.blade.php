<x-app-layout>
    <section class="bg-gray-700 py-12 mb-12">
        <div class="container grid grid-cols-1 lg:grid-cols-2 gap-6">
            <figure>
                <img class="h-60 w-full object-cover" src="{{$course->image}}" alt="">
            </figure>

            <div class="text-white flex flex-col justify-center items-center">
                <h1 class="text-4xl mb-3">{{$course->title}}</h1>
                <p class="mb-2"><i class="fas fa-chart-line"></i>Nivel: {{$course->level->name}}</p>
                <p class="mb-2"><i class=""></i>Categoría: {{$course->category->name}}</p>
                <p class="mb-2"><i class="fas fa-users"></i>Matriculados: {{$course->students_count}}</p>
                <p><i class="far fa-star"></i>Calificación: {{$course->rating}}</p>
            </div>
        </div>
    </section>

    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="order-2 lg:col-span-2 lg:order-1">
            <section class="card mb-12">
                <div class="card-body">
                    <h1 class="font-bold text-2xl mb-2">Lo que Aprenderás:</h1>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 ">
                        @foreach ($course->goals as $goal)
                            <li class="text-gray-700 text-base"><i class="fas fa-check text-gray-600 mr-2"></i>{{$goal->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <!--Hay que crear las lessons y sections-->
            <section>
                <h1 class="font-bold text-3xl mb-2 ">Temario</h1>

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
                            <h1 class="font-bold text-lg text-gray-600">{{$section->name}}</h1>
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

            <section class="mt-12 mb-8">
                <h1 class="font-bold text-3xl">Requisitos</h1>
                <ul class="list-disc list-inside">
                    @foreach ($course->requirements as $requirement)
                        <li class="text-gray-700 text-base">{{$requirement->name}}</li>
                    @endforeach 
                </ul>
            </section>

            <section class="mt-12 mb-8">
                <h1 class="font-bold text-3xl">Descripción</h1> 
                <div class="text-gray-700 text-base">
                    {{$course->description}}

                    @if($course->description==null)
                    <p class="text-gray-700 text-base mt-4">No hay descripción del course, todavía.</p>
                @endif
                </div>
            </section>

            <section class="mt-12 mb-8">
                <h1 class="font-bold text-3xl mb-4 mt-2">Reseñas</h1>
                <p class="text-gray-700 text-base mb-2">Número de estudiantes matriculados: <strong>{{ $course->students_count }}</strong></p>
                <p class="text-gray-700 text-base mb-2">Puntuación media: <strong>{{ $course->rating }}</strong></p>
            
                <h2 class="font-bold text-2xl mt-4 mb-4">Últimas Reseñas</h2>
                <div class="flex space-x-4">
                    @foreach($recentReviews as $review)
                        <div class="bg-white p-4 rounded-lg shadow-md w-1/3">
                            <p class="font-bold">{{ $review->user->name }} </p>
                            <p><span class="text-sm text-gray-500">(Calificación: <strong>{{ $review->rating }}</strong>)</span></p>
                            <p class="text-gray-700 text-sm truncate">{{ $review->comment }}</p>
                            <button class="text-blue-500 text-xs" onclick="this.previousElementSibling.classList.toggle('truncate'); this.classList.toggle('hidden')">Leer más</button>
                        </div>
                    @endforeach
                </div>

                @if($recentReviews->isEmpty())
                    <p class="text-gray-700 text-base mt-4">No hay reseñas todavía.</p>
                @endif
            </section>
            

        </div>

        <div class="order-1 lg:order-2">
            <section class="card mb-4">
                <div class="card-body">

                    <div class="flex items-center">
                        <img class="h-12 w-12 object-cover rounded-full shadow-lg" src="{{$course->teacher->profile_photo_url}}" alt="{{$course->teacher->name}}">
                        <div class="ml-4">
                            <h1 class="font-bold text-gray-500">Prof. {{$course->teacher->name}}</h1>
                            <a class="text-blue-400 text-sm font-bold" href="{{$course->teacher->email}}">{{'@'. Str::slug($course->teacher->name, '')}}</a>
                        </div>
                    </div>
                    @can('enrolled', $course)

                            <a class="btn btn-danger btn-block mt-4" href="{{route('courses.status', $course)}}">
                                Continuar con el curso
                            </a>
                         
                    @else
                            {{--Le paso la ruta de matriculación, y el objeto curso a matricular--}}
                            <form action="{{route('course.enrolled', $course)}}" method="post">
                                @csrf {{--token csrf necesario para enviar datos por formulario--}}
                                <button class="btn btn-danger btn-block mt-4" type="submit">
                                    LLevar este Curso
                                </button>
                            </form>

                    @endcan
                </div>
            </section>

            <aside class="hidden lg:block">
                <h1 class="font-bold text-3xl mb-4">Cursos Similares</h1>
                @if ($similares->count()!=0)
                    @foreach ($similares as $similar)
                        <article class="flex mb-6">
                            <img class="h-32 w-40 object-cover" src="{{$similar->image}}" alt="">

                            <div class="ml-3">
                                <h1><a class="font-bold text-gray-500 mb-3 cursor-pointer" href="{{route('courses.show', $similar)}}">{{Str::limit($similar->title, 30)}}</a></h1>
                                

                                <div class="flex items-center mb-2">
                                    <img class="h-8 w-8 object-cover rounded-full shadow-lg" src="{{$similar->teacher->profile_photo_url}}" alt="">
                                    <p class="text-gray-700 text-sm ml-2">{{$similar->teacher->name}}</p>
                                </div>

                                <p class="text-sm"><i class="fas fa-star mr-2 text-yellow-400">{{" " . $similar->rating}}</i></p>
                            </div>
                        </article>
                    @endforeach
                @else
                    <p class="text-gray-700 text-base">En este momento, no hay cursos similares a este</p>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>