@php /*
    

<x-instructor-layout>
    <!--Copiado de la vista dashboard.blade.php, lo utilizaré para la cabecera del listado de cursos-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listado de Cursos
        </h2>
    </x-slot>

    <!--En la carpeta components defino un componente con clases de centrado, y lo aplico aqui-->
    <x-container class="mt-12 ">
        <div class="md:flex md:justify-end mb-6">
            <!--En la carpeta css defino clases copiadas de tail wind component y las llamo aqui para el botón-->
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-red block w-full md:w-auto text-center">
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
                                <div class="grid md:grid-cols-9">
                                    <div class="md:col-span-3 text-center">
                                        <h1 class="mb-4">{{ $course->title }}</h1>

                                        <!--Se definió en un enum correspondencia entre números y nombres-->
                                        <!--Copio el código de los badges de tail wind-->
                                        @switch($course->status->name)
                                            @case('BORRADOR')
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                                    {{ $course->status->name }}
                                                </span>
                                                @break
                                            @case('PENDIENTE')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                    {{ $course->status->name }}
                                                </span>
                                                @break
                                            @case('PUBLICADO')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $course->status->name }}
                                                </span>
                                                @break
                                            @default
                                        @endswitch
                                        
                                    </div>

                                    <div class="hidden md:block col-span-2 text-center">
                                        <p class="text-sm font-bold">100 €</p>
                                        <p class="mt-1 text-sm">Ganado este mes</p>
                                        <p class="text-sm font-bold">1000 €</p>
                                        <p class="text-sm">Ganado en total</p>
                                    </div>

                                    <div class="hidden md:block col-span-2 text-center">
                                        <p class="text-sm font-bold">50</p>
                                        <p class="text-sm">Inscriciones este mes</p>
                                    </div>

                                    <div class="hidden md:block col-span-2">
                                        <div class="flex justify-end">
                                            <p class="mr-3">5</p>
                                            <ul class="text-xs space-x-1 flex items-center">
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="md:col-span-2 flex items-center justify-center space-x-4 mt-4 md:mt-0">
                                        <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-blue">
                                            Editar
                                        </a>
                                        <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="btn btn-red">
                                                Eliminar
                                            </x-button>
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
*/
@endphp