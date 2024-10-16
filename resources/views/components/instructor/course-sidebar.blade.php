<!--Componente creado para reutilizar en varias vistas, entre ellas la vista edit.blade.php-->

@props(['course'])

@php
//Desarrollo los links dinamicamente
    $links=[
        [
            'name'=>'Información del Curso',
            'url'=>route('instructor.courses.edit', $course),
            'active'=>request()->routeIs('instructor.courses.edit')
        ],
        // [
        //     'name'=>'Video Promocional',
        //     'url'=>route('instructor.courses.video', $course),
        //     'active'=>request()->routeIs('instructor.courses.video')
        // ],
        [
            'name'=>'Metas del Curso',
            'url'=>route('instructor.courses.goals', $course),
            'active'=>request()->routeIs('instructor.courses.goals')
        ],
        [
            'name'=>'Requisitos del Curso',
            'url'=>route('instructor.courses.requirements', $course),
            'active'=>request()->routeIs('instructor.courses.requirements')
        ],
        [
            'name'=>'Curriculum del Curso',
            'url'=>route('instructor.courses.curriculum', $course),
            'active'=>request()->routeIs('instructor.courses.curriculum')
        ],
    ]
@endphp
<x-container class="py-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 ">

        <aside class="col-span-1">

            <h1 class="font-bold text-xl mb-4 text-center lg:text-left">Edición del Curso</h1>
            <nav>
                    <ul class="space-y-2">
                        @foreach ($links as $link)
                            <li class="{{$link['active'] ? 'border-indigo-400' : 'border-transparent'}} text-center lg:text-left border-b-4 pb-2>
                                <a href="{{$link['url']}}">
                                {{$link['name']}}
                                </a>
                            </li>                         
                        @endforeach
                    </ul>
            </nav>
        </aside>

        <div class="col-span-1 lg:col-span-4">
            <div class="card mt-3">
                {{$slot}}
            </div>
        </div>
    </div>
</x-container>
