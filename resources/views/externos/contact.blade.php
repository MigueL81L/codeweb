<x-guest-layout>
    <div class="min-h-screen bg-gray-800 flex items-center justify-center"> <!-- Fondo gris y centrado -->
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full border-2"> <!-- Contenedor blanco -->
            <!-- Encabezado con el logo -->
            <div class="flex justify-center mb-8">
                <x-application-mark class="h-10" />
                <!-- Eliminado el nombre duplicado de la aplicación -->
            </div>

            <!-- Cuadrícula para contenido -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Imagen de contacto -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/externos/contacto.jpg') }}" alt="Contacto" class="rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;" />
                </div>

                <!-- Información de contacto -->
                <div>
                    <h1 class="text-3xl font-bold mb-4 text-center">Información de Contacto</h1>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">Puedes encontrarnos en:</p>
                    <div class="mt-4">
                        <div class="flex justify-start mb-2"> <!-- Primera fila: Dirección -->
                            <span class="font-semibold w-32 text-right pr-4">Dirección:</span>
                            <p class="text-gray-700 dark:text-gray-300">Calle Ficticia 123, Pontevedra</p>
                        </div>
                        <div class="flex justify-start mb-2"> <!-- Segunda fila: Teléfono -->
                            <span class="font-semibold w-32 text-right pr-4">Teléfono:</span>
                            <p class="text-gray-700 dark:text-gray-300">612-345-678</p>
                        </div>
                        <div class="flex justify-start"> <!-- Tercera fila: Email -->
                            <span class="font-semibold w-32 text-right pr-4">Email:</span>
                            <p class="text-gray-700 dark:text-gray-300">
                                <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información sobre Donaciones -->
                <div class="text-center">
                    <h2 class="text-2xl font-semibold">Contribuciones Voluntarias</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">
                        Si deseas contribuir a nuestro proyecto, puedes hacer una donación voluntaria a través de Bizum. 
                        Para más detalles, visita nuestra 
                        <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>





