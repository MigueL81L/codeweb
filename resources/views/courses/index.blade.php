
<x-app-layout>
        <!--Cabecera, Buscador-->
        <section style="background-image: url({{ asset('public/img/cursos/portada.jpg') }})" class="bg-cover">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-36">
                <div class="w-full md:w-3/4 lg:w-1/2">
                    <h1 class="text-white font-bold text-4xl">Los mejores cursos de Programación</h1>
                    <p class="text-white text-lg mt-2 mb-4">Si estás buscando potenciar tus conocimientos de 
                        programación, aqui tenemos los cursos que necesitas! 
                    </p>
    
                    <!--componente search bar de tailwind, copiado de página de componentes tailwind--> 
                    {{--Código buscador encapsulado en componente livewire--}}
                    @livewire('search')
                </div>
            </div>
        </section>


        <!--Llamo al componente livewire CourseIndex previamente creado-->
        @livewire('course-index');  
</x-app-layout>