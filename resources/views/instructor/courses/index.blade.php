<x-instructor-layout>
    <!--Copiado de la vista dashboard.blade.php, lo utilizaré para la cabecera del listado de cursos-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center sm:text-start">
            Listado de Cursos
        </h2>
    </x-slot>

    <!--En la carpeta components defino un componente con clases de centrado, y lo aplico aqui-->
    <x-container class="mt-12 ">
        <div class="flex justify-center md:justify-end mb-6">
            <!--En la carpeta css defino clases copiadas de tail wind component y las llamo aqui para el botón-->
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-secondary w-full md:w-auto text-center">
                Crear Nuevo Curso
            </a>
        </div>

        <!--Colección de cursos que le corresponden al usuario-->
        <ul>
            @forelse ($courses as $course)
                <li class="bg-white rounded-lg shadow-lg overflow-hidden mb-4">
                    <div class="md:flex">
                        <!--No reducirá el tamaño de la imagen-->
                        <figure class="flex-shrink-0">
                            <!--Imagen cuadrada no deformable y centrada -->
                            <img src="{{ $course->image }}" 
                                alt="" 
                                class="w-full aspect-video md:w-36 md:aspect-square object-cover object-center" />
                        </figure>
                    
                        <div class="flex-1">
                            <div class="py-4 px-8">
                                <div class="grid md:grid-cols-12"> 

                                    <div class="md:col-span-6 lg:col-span-3 text-center">
                                        <p class="mt-1 text-sm">Curso</p>
                                        <p class="text-sm font-bold mt-2">{{ $course->title }}</p> 
                                    </div>

                                    <!--Desaparecen en menos que lg-->
                                    <div class="hidden lg:block col-span-2 text-center">
                                        <p class="mt-1 text-sm">Ganado en total</p>
                                        <p class="text-sm font-bold mt-2">{{ ($course->students_count * $course->price_value) . ' €' }}</p>
                                    </div>

                                    <div class="hidden lg:block col-span-2 text-center">
                                        <p class="text-sm mt-1">Estudiantes matriculados</p>
                                        <p class="text-sm font-bold mt-2">{{$course->students_count}}</p>
                                    </div>

                                    <div class="hidden lg:block col-span-2">
                                        <div class="flex justify-end">
                                            
                                            @if($course->rating !=0)
                                                <div>
                                                    <p class="text-sm text-center mt-1 mb-2">Rating</p>
                                                    <ul class="flex text-sm">
                                                        <li class="mr-1">
                                                            <i class="fas fa-star text-{{$course->rating >=1 ? 'yellow':'gray'}}-400"></i>
                                                        </li>
                                                        <li class="mr-1">
                                                            <i class="fas fa-star text-{{$course->rating >=2 ? 'yellow':'gray'}}-400"></i>
                                                        </li>
                                                        <li class="mr-1">
                                                            <i class="fas fa-star text-{{$course->rating >=3 ? 'yellow':'gray'}}-400"></i>
                                                        </li>
                                                        <li class="mr-1">
                                                            <i class="fas fa-star text-{{$course->rating >=4 ? 'yellow':'gray'}}-400"></i>
                                                        </li>
                                                        <li class="mr-1">
                                                            <i class="fas fa-star text-{{$course->rating ==5 ? 'yellow':'gray'}}-400"></i>
                                                        </li>
                                                        <p class="ml-3 font-bold">{{$course->rating}}</p>
                                                    </ul>
                                                </div>
                                            @else
                                                <ul>
                                                    <p class="text-sm mt-1 text-center">Rating</p>
                                                    <li class=" text-sm font-bold mt-2 text-center">
                                                        <p>Sin reseñas</p>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="md:col-span-6 lg:col-span-3 flex items-center justify-center sm:justify-end space-x-4 mt-4 md:mt-0">
                                        <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-blue">
                                            Editar
                                        </a>
                                        <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty 
                <li class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center">
                        <p>
                            Salta a la Creación de un Curso
                        </p>
                        <a href="{{ route('instructor.courses.create') }}" class="btn btn-blue">
                            Crea tu Primer Curso
                        </a>
                    </div>
                </li>
            @endforelse
        </ul>
    </x-container>
</x-instructor-layout>



