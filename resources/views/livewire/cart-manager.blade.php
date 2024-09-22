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

                        <div class="mt-4">
                            {{-- Botón para eliminar el curso del carrito --}}
                            <button wire:click="remove('{{ $item->rowId }}')" class="text-red-500 underline hover:text-red-700">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <div>
                    {{-- Botón para proceder con el pago y la matrícula --}}
                    <button wire:click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Continuar con el pago</button>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Mensaje de éxito tras compra si lo hay --}}
    @if (session()->has('message'))
        <div class="mt-4 bg-green-500 text-white p-4 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>



