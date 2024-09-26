<footer class="bg-white dark:bg-gray-900 mt-16">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8"> 
        <div class="md:flex md:justify-between"> 
            <div class="mb-6 md:mb-0 flex items-start">
            {{-- <div class="w-full mb-6 sm:justify-center sm:items-center md:mb-0 flex items-start"> --}}
                <x-application-mark class="h-8 mr-3" />
                <!-- Eliminado el nombre duplicado de la aplicación -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-16 sm:gap-12 flex-grow"> <!-- Aumentado el espacio entre bloques con gap-16 -->
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Nosotros</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{ route('who-we-are') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline sm:text-center">Quienes Somos</a> <!-- Nuevo enlace a Quienes Somos -->
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('contact') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Contáctanos</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm sm:text-center font-semibold text-gray-900 uppercase dark:text-white">Compañía</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium sm:text-center">
                        <li class="mb-4">
                            <a href="{{ route('privacy-policy') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Política de Privacidad</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('terms-and-conditions') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Términos y Condiciones</a>
                        </li>
                        <li>
                            <a href="{{ route('accessibility-statement') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Declaración de Accesibilidad</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 dark:border-gray-700" style="width: 100%; margin-left: 0; margin-right: 0;" />
        <div class="text-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">© 2024 CodeWeb. Todos los derechos Reservados.</span>
        </div>
    </div>
</footer>










