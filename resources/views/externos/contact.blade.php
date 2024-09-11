<x-guest-layout>
    <div class="container mx-auto py-6 px-4 lg:px-8">
        <!-- Header con el logo -->
        <div class="flex items-center mb-8">
            <x-application-mark class="h-10 mr-3" />
            <!-- Eliminado el nombre duplicado de la aplicación -->
        </div>

        <!-- Descripción de la Academia -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">¿A qué nos dedicamos?</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">
                En CodeWeb ofrecemos cursos de programación gratuitos para ayudar a los estudiantes a iniciar su carrera en el mundo del desarrollo de software. Nuestros cursos están diseñados para ser accesibles, prácticos y orientados a proyectos, brindando a los estudiantes las habilidades necesarias para tener éxito.
            </p>
        </div>

        <!-- Información de contacto -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">Contáctanos</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">Puedes encontrarnos en:</p>
            <ul class="list-disc pl-5 mt-2 text-gray-700 dark:text-gray-300">
                <li><strong>Dirección:</strong> Calle Ficticia 123, Pontevedra</li>
                <li><strong>Teléfono:</strong> 123-456-789</li>
                <li><strong>Email:</strong> <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a></li>
            </ul>
        </div>

        <!-- Información sobre Donaciones -->
        <div>
            <h2 class="text-2xl font-semibold">Contribuciones Voluntarias</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">
                La academia es gratuita, pero si te sientes generoso y deseas contribuir, puedes hacer una donación voluntaria a través de Bizum. 
                Para obtener más información sobre cómo hacer una donación, visita nuestra 
                <a href="{{ route('payment-address') }}" class="text-blue-600 hover:underline">Dirección de Pago</a>.
            </p>
        </div>
    </div>
</x-guest-layout>


