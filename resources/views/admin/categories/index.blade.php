<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Lista de Categorías',
        'url' => route('admin.categories.index'),
    ]
]">

@if(session('info'))
    <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
        <strong>Éxito! </strong>{{ session('info') }}
    </div>
@endif

<div class="card">

    <div class="card-body">
        <div class="table-responsive">

            <div class="flex items-center py-4">
                <a class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" href="{{ route('admin.categories.create') }}">Crear Categoría</a>
            </div>

            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"> <!-- Alternar colores entre filas -->
                            <td class="border px-4 py-2 text-center">{{ $category->name }}</td>
                            
                            <td class="border px-4 py-2 text-center">
                                <a class="btn btn-secondary inline-block" href="{{ route('admin.categories.edit', $category) }}">Editar</a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block ml-2">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center">No hay ninguna categoría registrada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-admin-layout>