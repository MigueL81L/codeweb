<x-guest-layout>
    <div class="container mx-auto py-6 px-4 lg:px-8">
        <!-- Encabezado con el logo -->
        <div class="flex justify-center mb-8">
            <x-application-mark class="h-10 mr-3" />
            <!-- Eliminado el nombre duplicado de la aplicación -->
        </div>

        <!-- Imagen ajustada a su tamaño original -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('img/externos/contacto.jpg') }}" alt="Contacto" class="rounded-lg shadow-lg max-w-full h-auto" /> <!-- Ajustada a tamaño original -->
        </div>

        <!-- Información de contacto -->
        <div>
            <h1 class="text-3xl font-bold mb-4">Información de Contacto</h1>
            <p class="mt-2 text-gray-700 dark:text-gray-300">Puedes encontrarnos en:</p>
            <ul class="list-disc pl-5 mt-2 text-gray-700 dark:text-gray-300">
                <li><strong>Dirección:</strong> Calle Ficticia 123, Pontevedra</li>
                <li><strong>Teléfono:</strong> 612-345-678</li>
                <li><strong>Email:</strong> <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a></li>
            </ul>
        </div>

        <!-- Información sobre Donaciones -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold">Contribuciones Voluntarias</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">
                Si deseas contribuir a nuestro proyecto, puedes hacer una donación voluntaria a través de Bizum. 
                Para más detalles, visita nuestra 
                <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
            </p>
        </div>
    </div>
</x-guest-layout>



