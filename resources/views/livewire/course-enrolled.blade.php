
<div>

    <!--Consulta la colección de courses presente en la instancia 'shoppig', 
    si es que existe algún course, agregado al carrito, cuyo id coincide-->

    <!--Carrito-->
    @if (Cart::instance('shopping')->content()->where('id', $course->id)->first())
        <button 
            wire:key="removeCart"
            wire:click="removeCart"
            class="btn btn-blue w-full uppercase mb-2"> 
                Eliminar de la cesta
        </button>
    @else
        <button 
            wire:key="addCart"
            wire:click="addCart"
            class="btn btn-blue w-full uppercase mb-2">
                Agregar a la cesta
        </button>
    @endif


    <!--Carrito + siguiente nivel -->
        <button 
            wire:key="buyNow"
            wire:click="buyNow"
            class="btn btn-red w-full uppercase">
                Comprar ahora
        </button>





        <div class="container mx-auto py-6">
            <h1 class="text-2xl font-semibold mb-4">Contenido del Carrito de Prueba</h1>
    
            @if($cartContent->isEmpty())
                <p>No hay elementos en el carrito.</p>
            @else
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="w-1/4 px-6 py-3 text-left">Nombre</th>
                            <th class="w-1/4 px-6 py-3 text-left">Cantidad</th>
                            <th class="w-1/4 px-6 py-3 text-left">Precio</th>
                            <th class="w-1/4 px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartContent as $item)
                            <tr>
                                <td class="border px-6 py-3">{{ $item->name }}</td>
                                <td class="border px-6 py-3">{{ $item->qty }}</td>
                                <td class="border px-6 py-3">{{ $item->price }} €</td>
                                <td class="border px-6 py-3">
                                    <ul>
                                        @foreach($item->options as $optionKey => $optionValue)
                                            <li><strong>{{ ucfirst($optionKey) }}</strong>: {{ $optionValue }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
</div>







