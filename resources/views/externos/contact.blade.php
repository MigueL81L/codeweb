<x-guest-layout>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center"> <!-- Fondo gris en toda la pantalla -->
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full"> <!-- Contenedor blanco centrado -->
            <!-- Encabezado con el logo -->
            <div class="flex justify-center mb-8">
                <x-application-mark class="h-10 mr-3" />
            </div>

            <!-- Imagen ajustada a un tamaño razonable -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('img/externos/contacto.jpg') }}" alt="Contacto" class="rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;" />
            </div>

            <!-- Información de contacto -->
            <div>
                <h1 class="text-3xl font-bold mb-4 text-center">Información de Contacto</h1>
                <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">Puedes encontrarnos en:</p>
                <div class="mt-4">
                    <div class="flex justify-start mb-2">
                        <span class="font-semibold w-32 text-right pr-4">Dirección:</span>
                        <p class="text-gray-700 dark:text-gray-300">Calle Ficticia 123, Pontevedra</p>
                    </div>
                    <div class="flex justify-start mb-2">
                        <span class="font-semibold w-32 text-right pr-4">Teléfono:</span>
                        <p class="text-gray-700 dark:text-gray-300">612-345-678</p>
                    </div>
                    <div class="flex justify-start">
                        <span class="font-semibold w-32 text-right pr-4">Email:</span>
                        <p class="text-gray-700 dark:text-gray-300">
                            <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Información sobre Donaciones -->
            <div class="mt-6 text-left">
                <h2 class="text-2xl font-semibold text-center">Contribuciones Voluntarias</h2>
                <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">
                    Si deseas contribuir a nuestro proyecto, puedes hacer una donación voluntaria a través de Bizum. 
                    Para más detalles, visita nuestra 
                    <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>



