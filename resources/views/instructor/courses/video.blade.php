<x-instructor-layout>
    <!--Cabecera-->
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Curso: {{ $course->title}}
            </h2>
        </x-slot>

        <!--Llamo al componente course-sidebar, que tiene dentro el componente x-container-->
        <x-instructor.course-sidebar :course="$course">

            <!--Incluyo componenete livewire previamente creado en la terminal, para que la carga del vídeo 
            se haga en segundo plano, y no paralice la vista-->
            @livewire('instructor.courses.promotional-video', ['course'=>$course])

        </x-instructor.course-sidebar>


    

</x-instructor-layout>