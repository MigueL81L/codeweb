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

                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">
                        En **CodeWeb**, somos una academia virtual dedicada a ofrecer formación accesible en programación, bases de datos, y otras disciplinas de la informática. Nuestros cursos están diseñados para todos los niveles, desde principiantes hasta profesionales que buscan mejorar sus habilidades.
                    </p>

                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">
                        Nuestros instructores son expertos en sus campos, y están comprometidos a brindarte una experiencia de aprendizaje enriquecedora, práctica y eficaz. Creemos en el poder de la educación online y en su capacidad para flexibilizar tu aprendizaje, adaptándose a tu ritmo y horario.
                    </p>

                    <h2 class="text-2xl font-semibold mt-4 text-center">Información de Contacto</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">Puedes encontrarnos en:</p>
                    <div class="mt-4">
                        <div class="flex justify-start mb-2">
                            <span class="font-semibold w-32 text-right pr-4">Dirección:</span>
                            <span class="text-gray-700 dark:text-gray-300">Calle Ficticia 123, Pontevedra</span>
                        </div>
                        <div class="flex justify-start mb-2">
                            <span class="font-semibold w-32 text-right pr-4">Teléfono:</span>
                            <span class="text-gray-700 dark:text-gray-300">612-345-678</span>
                        </div>
                        <div class="flex justify-start">
                            <span class="font-semibold w-32 text-right pr-4">Email:</span>
                            <span class="text-gray-700 dark:text-gray-300">
                                <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a>
                            </span>
                        </div>
                    </div>

                    <!-- Información sobre Donaciones -->
                    <h2 class="text-2xl font-semibold mt-4 text-center">Contribuciones Voluntarias</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-left">
                        Si deseas contribuir a nuestro proyecto, puedes hacer una donación voluntaria a través de Bizum. 
                        Para más detalles, visita nuestra 
                        <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
















