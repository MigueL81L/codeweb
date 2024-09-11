<x-guest-layout>
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="pt-4 pb-12 bg-gray-100 dark:bg-gray-900">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <x-application-mark class="h-10" />
                </div>

                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('img/externos/contacto.jpg') }}" alt="Contacto" class="rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;" />
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold mb-4 text-center">Información de Contacto</h1>
                        <p class="mt-2 text-gray-700 dark:text-gray-300 text-center">Puedes encontrarnos en:</p>
                        <div class="mt-4">
                            <div class="flex justify-start mb-2"> <!-- Primera fila: Dirección -->
                                <span class="font-semibold w-32 text-right pr-4">Dirección:</span>
                                <span class="text-gray-700 dark:text-gray-300">Calle Ficticia 123, Pontevedra</span>
                            </div>
                            <div class="flex justify-start mb-2"> <!-- Segunda fila: Teléfono -->
                                <span class="font-semibold w-32 text-right pr-4">Teléfono:</span>
                                <span class="text-gray-700 dark:text-gray-300">612-345-678</span>
                            </div>
                            <div class="flex justify-start"> <!-- Tercera fila: Email -->
                                <span class="font-semibold w-32 text-right pr-4">Email:</span>
                                <span class="text-gray-700 dark:text-gray-300">
                                    <a href="mailto:mNight@gmail.com" class="text-blue-600 hover:underline">mNight@gmail.com</a>
                                </span>
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
    </div>
</x-guest-layout>





