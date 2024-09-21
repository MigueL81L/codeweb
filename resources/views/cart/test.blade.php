<x-app-layout>
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
</x-app-layout>

