<x-admin-layout :breadcrumb="[
    ['name' => 'Panel de Control', 'url' => route('admin.dashboard')],
    ['name' => 'Lista de Precios', 'url' => route('admin.prices.index')]
]"
>

@if(session('info'))
    <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
        <strong>Éxito! </strong>{{ session('info') }}
    </div>
@endif

<div class="sm:h-screen">
    <div class="card-body">
        <div class="table-responsive">
            <div class="flex items-center sm:justify-start py-4">
                <a class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-8 rounded text-center" href="{{ route('admin.prices.create') }}">Crear Precio</a>
            </div>

            <table class="mx-auto sm:w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-center">Precio, (€)</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prices as $price)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="border px-4 py-2 text-center">{{ $price->value }}</td>

                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.prices.edit', $price) }}">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded inline-block">
                                        Editar
                                    </button>
                                </a>

                                <form action="{{ route('admin.prices.destroy', $price) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este Precio? Esta acción eliminará todos los cursos asociados y sus recursos.')"  class="inline-block ml-2">
                                    @method('delete')
                                    @csrf
                                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded inline-block mt-2 mr-1 sm:mt-0 sm:mr-0" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="border px-4 py-2 text-center">No hay ningún precio registrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-admin-layout>
