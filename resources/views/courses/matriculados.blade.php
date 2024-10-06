
<x-app-layout>
    <!--Cabecera, Buscador-->
    <section style="background-image: url({{ asset('img/cursos/matriculados.jpg') }})" class="bg-cover">
    {{-- <section style="background-image: url({{ asset('img/logo/Logo64.png') }})" class="bg-cover"> --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-36">
            <div class="w-full md:w-3/4 lg:w-1/2">
                <h1 class="text-white font-bold text-4xl">Tus cursos en los que has matriculado</h1>
                <p class="text-white text-lg mt-2 mb-4">Si estás buscando potenciar tus conocimientos de 
                    programación, has llegado al lugar adecuado. Estos son los cursos, en los que te has matriculado.
                </p>
            </div>
        </div>
    </section>

    <!--Llamo al componente livewire CourseIndex previamente creado-->
    @livewire('course-matriculados');  
</x-app-layout>