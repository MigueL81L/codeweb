<!--Mediante la directiva props le estoy diciendo que $course, se le pasa como atributo del componente-->
@props(['course'])




<article class="card">
    <!-- Usa el accesor `image` para la imagen del curso -->
    <img src="{{ $course->image }}" alt="Imagen del Curso" class="w-full h-36 object-cover"> 

    <div class="card-body">
        <!--Mediante el helper Str y el método limit, limito los títulos a como mucho 40
            caracteres. A partir del caracter nº41 me mostrará ...-->
        <h1 class="card-title">{{Str::limit($course->title,25)}}</h1>

        @if ($course->teacher) <!-- Verifica si hay un profesor asignado al curso -->
        <p class=" text-gray-500 text-sm mb-2">Prof: {{ $course->teacher->name }}</p> <!-- Accede al nombre del profesor -->
        @else
            <p class=" text-gray-500 text-sm mb-2">Profesor no asignado</p>
        @endif
        
        <div class="flex">
            <!--Estrellitas del rating, cada li, será una estrellita-->
            <ul class="flex text-sm">
                @if($course->rating !=0)
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
                @else
                    <li class=" text-gray-500 text-sm mr-1">
                        <p>Sin reseñas</p>
                    </li>
                @endif
            </ul>

            <p class="text-sm text-gray-500 ml-auto">  
                <i class="fas fa-users"></i>
                ({{$course->students_count}})
            </p>
        </div>

        <!--Botón normal azul, clase persona. btn btn-primary-->
        <!--Botón que debe abarcar todo el ancho btn btn-block-->
        <a href="{{route('courses.show', $course)}}" class="btn-block mt-4 btn btn-primary">
            Ir al Curso 
        </a>
    </div>
</article>