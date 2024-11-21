<x-admin-layout :breadcrumb="[
    ['name' => 'Panel de Control', 'url' => route('admin.dashboard')],
    ['name' => 'Editar Precio', 'url' => '#'],
]">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.prices.update', $price) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Valor del Precio -->
                <div class="mb-4">
                    <label for="value" class="block text-sm font-medium text-gray-700">Valor del Precio</label>
                    <input type="text" name="value" id="value" placeholder="Escriba un valor" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('value', $price->value) }}">

                    @error('value')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Precios Existentes -->
                <div class="mb-4">
                    <h2 class="font-bold">Precios Existentes, (€)</h2>
                    @foreach($prices as $item)
                        <div class="mt-2">
                            <ul class="mt-2">
                                <li>
                                    <span class="ml-2 text-gray-700">{{ $item->value }}</span>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>

                
                <div class="mb-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <!-- Botón de Enviar -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2 sm:mb-0">Actualizar Precio</button>

                    <!-- Botón de Cancelar -->
                    <button type="button" onclick="window.location='{{ route('admin.prices.index') }}'" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
