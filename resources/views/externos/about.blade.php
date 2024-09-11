<x-guest-layout>
    <div class="container mx-auto py-6 px-4 lg:px-8">
        <!-- Encabezado con el logo -->
        <div class="flex justify-center mb-8">
            <x-application-mark class="h-10 mr-3" />
            <!-- Eliminado el nombre duplicado de la aplicación -->
        </div>

        <!-- Imagen ajustada a un tamaño razonable -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('img/externos/contacto.jpg') }}" alt="Contacto" class="rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;" />
        </div>

        <!-- Información de contacto -->
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-4">Información de Contacto</h1>
            <p class="mt-2 text-gray-700 dark:text-gray-300">Puedes encontrarnos en:</p>
            <div class="mt-4">
                <div class="flex justify-center">
                    <div class="mr-12">
                        <span class="font-semibold">Dirección:</span>
                        <p class="text-gray-700 dark:text-gray-300">Calle Ficticia 123, Pontevedra</p>
                    </div>
                    <div class="mr-12">
                        <span class="font-semibold">Teléfono:</span>
                        <p class="text-gray-700 dark:text-gray-300">612-345-678</p>
                    </div>
                    <div>
                        <span class="font-semibold">Email:</span>
                        <p class="text-gray-700 dark:text-gray-300">
                            <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información sobre Donaciones -->
        <div class="mt-6 text-center">
            <h2 class="text-2xl font-semibold">Contribuciones Voluntarias</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">
                Si deseas contribuir a nuestro proyecto, puedes hacer una donación voluntaria a través de Bizum. 
                Para más detalles, visita nuestra 
                <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
            </p>
        </div>
    </div>
</x-guest-layout>






