<x-app-layout>
    <!--El método asset hace referencia a mi carpeta public-->
    <!--Cabecera, Buscador-->
    {{-- <section style="background-image: url({{ asset('img/home/pexelsHome.jpg') }})" class="bg-cover"> --}}
        <section style="background-image: url('https://codeweb.pw/img/home/pexelsHome.jpg')" class="bg-cover">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-36">
            <div class="w-full md:w-3/4 lg:w-1/2">
                <h1 class="text-white font-bold text-4xl">Domina la tecnología Web</h1>
                <p class="text-white text-lg mt-2 mb-4">En CodeWeb encontrarás cursos que 
                    te ayudarán a convertirte en un profesional del desarrollo Web</p>

                {{--Código buscador encapsulado en componente livewire--}}
                @livewire('search')
            </div>
        </div>
    </section>

    <!--Filtro-->
    <section class="mb-4 bg-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-center text-white text-3xl mb-2">¿No sabes que curso te puede interesar?</h1>
            <p class="text-center text-white  mb-2">
                Dirígete al catálogo de cursos y filtralos por categoría o nivel
            </p>
            <div class="flex justify-center mt-4">
                <a href="{{ route('courses.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded text-2xl">
                    Catálogo de Cursos
                </a>
            </div>
        </div>
    </section>

    <!--Listado últimos cursos-->
    <section class="mt-4 py-12">
        <h1 class="text-center text-3xl text-gray-600">Ultimos Cursos</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Siempre estamos subiendo Cursos</p>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($courses as $course)

                <!--Código encapsulado en un componente-->
                <x-instructor.course-card :course="$course" />

            @endforeach
        </div>
    </section>
</x-app-layout>







