

<footer class="bg-white dark:bg-gray-900 mt-2">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8"> 
        <div class="flex flex-col items-center text-center sm:flex-row sm:text-left sm:items-start md:justify-between"> 
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 sm:gap-12 flex-grow w-full sm:w-auto">
                <div class="mb-4 sm:mb-6 flex justify-center w-full sm:w-auto">
                    <x-application-mark class="h-8 mr-3" />
                </div>
                <div class="flex flex-col sm:items-start sm:text-left md:items-center md:text-center">
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Nosotros</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{ route('who-we-are') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Quienes Somos</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('contact') }}" class="hover:cursor-pointer hover:text-blue-600 no-underline">Contáctanos</a>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col sm:items-start sm:text-left md:items-center md:text-center">
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Compañía</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
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











