<x-guest-layout>
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="pt-4 pb-12 bg-gray-100 dark:bg-gray-900">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <x-application-mark class="h-10" />
                </div>

                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                    <h1 class="text-3xl font-bold mb-4 text-center">¿Quiénes Somos?</h1> <!-- Título de sección -->
                    
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('img/externos/equipo.jpg') }}" alt="Nuestro Equipo" class="rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;" />
                    </div>

                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-left">
                        En CodeWeb, somos una academia virtual dedicada a ofrecer formación accesible en programación, bases de datos, y otras disciplinas de la informática. Nuestros cursos están diseñados para todos los niveles, desde principiantes hasta profesionales que buscan mejorar sus habilidades.
                    </p>

                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-left">
                        Nuestros instructores son expertos en sus campos, y están comprometidos a brindarte una experiencia de aprendizaje enriquecedora, práctica y eficaz. Creemos en el poder de la educación online y en su capacidad para flexibilizar tu aprendizaje, adaptándose a tu ritmo y horario.
                    </p>

                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-left">
                        Te proponemos que entres y le eches un vistazo a la página, y a los cursos de los que dispondrás. Siempre estamos subiendo nuevos cursos. Puedes matricularte en tantos como quieras, y lo mejor de todo es que puedes hacerlo Gratis!. 
                    </p>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-left font-bold">
                        Eso si, si consideras que hacemos cursos de valor, agradeceríamos una donación, para ayudarnos a crecer, y atender a la cada día mayor comunidad de estudiantes que tenemos.
                    </p>
                    
                    <p>
                        <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
                    </p>


                </div>
            </div>
        </div>
    </div>
</x-guest-layout>