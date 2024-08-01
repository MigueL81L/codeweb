<x-admin-layout :breadcrumb="[
    ['name' => 'Panel de Control', 'url' => route('admin.dashboard')],
    ['name' => 'Detalles del Precio', 'url' => '#']
]">

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h2 class="font-bold text-lg">Detalles del Precio</h2>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Valor del Precio</label>
                <p class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 px-4 py-2">{{ $price->value }}</p>
            </div>
        </div>
    </div>
</x-admin-layout>
