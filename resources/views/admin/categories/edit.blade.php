<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Editar Categoría',
        'url' => '#',
    ]
    ]">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del Rol -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Categoría</label>
                    <input type="text" name="name" id="name" placeholder="Escriba una Categoría" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $category->name) }}">

                    @error('name')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Título de Permisos -->
                <div class="mb-4">
                    <h2 class="font-bold">Categorías Existentes</h2>
                    @foreach($categories as $item)
                        <div class="mt-2">
                            <ul class="mt-2">
                                <li>
                                    <span class="ml-2 text-gray-700">{{ $item->name }}</span>
                                </li>
                            </ul>
                        </div>
                    @endforeach

                </div>

                
                <div class="mb-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <!-- Botón de Enviar -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2 sm:mb-0">Actualizar Categoría</button>

                    <!-- Botón de Cancelar -->
                    <button type="button" onclick="window.location='{{ route('admin.categories.index') }}'" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>