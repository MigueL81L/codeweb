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

    <div >

        <div class="card-body">
            <div class="table-responsive">

                <div class="flex items-center sm:justify-start py-4">
                    <a class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-8 rounded text-center" href="{{ route('admin.categories.create') }}">Crear Categoría</a>
                </div>

                <table class="mx-auto sm:w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Nombre</th>
                            <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"> <!-- Alternar colores entre filas -->
                                <td class="border px-4 py-2 text-center">{{ $category->name }}</td>

                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('admin.categories.edit', $category) }}">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded inline-block">
                                            Editar
                                        </button>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta Categoría? Esta acción eliminará todos los cursos asociados y sus recursos.')" class="inline-block ml-2">
                                        @method('delete')
                                        @csrf
                                        <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded inline-block mt-2 mr-1"  type="submit">Eliminar</button>
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