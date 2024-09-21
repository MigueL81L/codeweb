<x-app-layout>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Contenido del Carrito</h1>
        
        @if ($cartContent->isEmpty())
            <p>No hay elementos en el carrito.</p>
        @else
            <div class="bg-white p-6 rounded-lg shadow-lg">
                @foreach($cartContent as $item)
                    <div class="flex items-start mb-6 pb-3 border-b border-gray-200">
                        <img src="{{ $item->options['image'] }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded">
                        
                        <div class="ml-4 flex-1">
                            <h2 class="text-lg font-bold">{{ $item->name }}</h2>
                            <p class="text-sm text-gray-500">Slug: {{ $item->options['slug'] }}</p>
                            <p class="text-sm text-gray-500">Profesor: {{ $item->options['teacher'] }}</p>
    
                            <div class="flex mt-2 space-x-4">
                                <div>
                                    <label class="block text-sm font-bold">Cantidad:</label>
                                    <input type="number" value="{{ $item->qty }}" min="1" max="10" class="border border-gray-300 rounded px-2 py-1 w-16">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold">Precio:</label>
                                    <p class="text-red-500 font-semibold">{{ $item->price }} €</p>
                                </div>
                            </div>
    
                            <div class="mt-4">
                                <button class="text-blue-500 underline hover:text-blue-700 mr-4">Guardar para más tarde</button>
                                <button class="text-red-500 underline hover:text-red-700">Eliminar</button>
                            </div>
                        </div>
                    </div>
                @endforeach
    
                <div class="flex justify-end mt-6">
                    <div>
                        <p class="text-lg font-semibold">Total Carrito: {{ Cart::instance('shopping')->total() }} €</p>
                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Continuar con el pago</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    
</x-app-layout>  