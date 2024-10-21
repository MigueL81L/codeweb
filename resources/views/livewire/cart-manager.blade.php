{{-- <div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4 text-center sm:text-start">Contenido de la Cesta</h1>

    @if ($cartContent->isEmpty())
        <p>No hay elementos en la Cesta.</p>
    @else
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @foreach($cartContent as $item)
                <div class="flex items-start mb-6 pb-3 border-b border-gray-200">
                    <img src="{{ $item->options['image'] }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded">
                    
                    <div class="ml-4 flex-1">
                        <h2 class="text-lg font-bold">{{ $item->name }}</h2>
                        @php
                            $iva = 0.10; // IVA del 10%
                            $priceWithIva = $item->price * (1 + $iva);
                        @endphp
                    <p class="text-sm text-gray-500">Profesor: {{ $item->options['teacher'] ?? 'Desconocido' }}</p>
                    <p class="text-sm text-gray-500">Precio con IVA: {{ number_format($priceWithIva, 2) . ' €' }}</p>

                        <div class="mt-4">

                            <button wire:click="remove('{{ $item->rowId }}')" class="text-red-500 underline hover:text-red-700">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <div class="flex items-center">

                    <p class="text-lg font-semibold mr-4">
                        Total ({{ $cartContent->count() }} {{ Str::plural('Curso', $cartContent->count()) }}):
                        {{ number_format($cartContent->sum('price'), 2) }} €
                    </p>

                    <button wire:click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Continuar con el pago
                    </button>
                </div>
            </div>
        </div>
    @endif
    

    @if (session()->has('message'))
        <div class="mt-4 bg-green-500 text-white p-4 rounded">
            {{ session('message') }}
        </div>
    @endif
</div> --}}

<div style="background-image: url({{ asset('public/img/cursos/carrito.jpg') }})" class="bg-cover"> 
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-36">

        <div class="w-full md:w-3/4 lg:w-1/2">

            @if ($cartContent->isEmpty())  
                <h1 class="text-2xl font-bold mb-6 text-center sm:text-start text-blue-500">Contenido de la Cesta</h1> 
                <p class="text-center font-bold sm:text-start text-blue-500">No hay elementos en la Cesta.</p>
            @else
                <div class="bg-white p-6 rounded-lg shadow-lg">

                    <h1 class="text-2xl font-semibold mb-6 text-center sm:text-start">Contenido de la Cesta</h1>

                    @foreach($cartContent as $item)
                        <div class="flex items-start mb-6 pb-3 border-b border-gray-200">
                            <img src="{{ $item->options['image'] }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded">
                            
                            <div class="ml-4 flex-1">
                                <h2 class="text-lg font-bold">{{ $item->name }}</h2>

                                @php
                                    $iva = 0.10; // IVA del 10%
                                    $priceWithIva = $item->price * (1 + $iva);
                                @endphp
                                    <p class="text-sm text-gray-500">Profesor: {{ $item->options['teacher'] ?? 'Desconocido' }}</p>
                                    <p class="text-sm text-gray-500">Precio con IVA: {{ number_format($priceWithIva, 2) . ' €' }}</p>
                                    
                                    <div class="mt-4">
                                        {{-- Botón para eliminar el curso de la cesta --}}
                                        <button wire:click="remove('{{ $item->rowId }}')" class="text-red-500 underline hover:text-red-700">
                                            Eliminar
                                        </button>
                                    </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end mt-6">
                        <div class="flex items-center">
                            @php
                                $totalWithIva = $cartContent->sum(fn($item) => $item->price * $item->qty * (1 + $iva));
                            @endphp
                                {{-- Mostrar cantidad total y precio total con IVA --}}
                                <p class="text-lg font-semibold mr-4">
                                    Total con IVA ({{ $cartContent->count() }} {{ Str::plural('Curso', $cartContent->count()) }}):
                                    {{ number_format($totalWithIva, 2) }} €
                                </p>
                                {{-- Botón para proceder con el pago y la matrícula --}}
                                <button wire:click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Continuar con el pago
                                </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        

        {{-- Mensaje de éxito tras compra si lo hay --}}
        @if (session()->has('message'))
            <div class="mt-4 bg-green-500 text-white p-4 rounded">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>

















{{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-36">
    <h1 class="text-2xl font-semibold mb-4 text-center sm:text-start">Contenido de la Cesta</h1>

    @if ($cartContent->isEmpty())   
            <p class="text-center sm:text-start">No hay elementos en la Cesta.</p>
    @else
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @foreach($cartContent as $item)
                <div class="flex items-start mb-6 pb-3 border-b border-gray-200">
                    <img src="{{ $item->options['image'] }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded">
                    
                    <div class="ml-4 flex-1">
                        <h2 class="text-lg font-bold">{{ $item->name }}</h2>
                        @php
                            $iva = 0.10; // IVA del 10%
                            $priceWithIva = $item->price * (1 + $iva);
                        @endphp
                        <p class="text-sm text-gray-500">Profesor: {{ $item->options['teacher'] ?? 'Desconocido' }}</p>
                        <p class="text-sm text-gray-500">Precio con IVA: {{ number_format($priceWithIva, 2) . ' €' }}</p>
                        
                        <div class="mt-4">

                            <button wire:click="remove('{{ $item->rowId }}')" class="text-red-500 underline hover:text-red-700">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <div class="flex items-center">
                    @php
                        $totalWithIva = $cartContent->sum(fn($item) => $item->price * $item->qty * (1 + $iva));
                    @endphp

                    <p class="text-lg font-semibold mr-4">
                        Total con IVA ({{ $cartContent->count() }} {{ Str::plural('Curso', $cartContent->count()) }}):
                        {{ number_format($totalWithIva, 2) }} €
                    </p>

                    <button wire:click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Continuar con el pago
                    </button>
                </div>
            </div>
        </div>
    @endif
    

</div>  --}}








