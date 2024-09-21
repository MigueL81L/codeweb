<x-app-layout>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Contenido del Carrito de Prueba</h1>
    
        @if($cartContent->isEmpty())
            <p>No hay elementos en el carrito.</p>
        @else
            <div class="bg-white p-6 rounded-lg shadow-lg">
                @foreach($cartContent as $item)
                    <div class="mb-6 border-b border-gray-200 pb-3">
                        <div class="flex mb-2">
                            <div class="w-1/4 font-bold">Nombre:</div>
                            <div class="w-3/4">{{ $item->name }}</div>
                        </div>
                        <div class="flex mb-2">
                            <div class="w-1/4 font-bold">Cantidad:</div>
                            <div class="w-3/4">{{ $item->qty }}</div>
                        </div>
                        <div class="flex mb-2">
                            <div class="w-1/4 font-bold">Precio:</div>
                            <div class="w-3/4">{{ $item->price }} €</div>
                        </div>
                        <div class="flex">
                            <div class="w-1/4 font-bold">Opciones:</div>
                            <div class="w-3/4">
                                <ul>
                                    @foreach($item->options as $optionKey => $optionValue)
                                        <li><strong>{{ ucfirst($optionKey) }}</strong>: {{ $optionValue }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
</x-app-layout>  