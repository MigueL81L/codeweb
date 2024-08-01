<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Editar Nivel',
        'url' => '#',
    ]
]">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.levels.update', $level) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del Rol -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Nivel</label>
                    <input type="text" name="name" id="name" placeholder="Escriba un Nivel" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $level->name) }}">

                    @error('name')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Título de Permisos -->
                <div class="mb-4">
                    <h2 class="font-bold">Niveles Existentes</h2>
                    @foreach($levels as $item)
                        <div class="mt-2">
                            <ul class="mt-2">
                                <li>
                                    <span class="ml-2 text-gray-700">{{ $item->name }}</span>
                                </li>
                            </ul>
                        </div>
                    @endforeach

                </div>

                <!-- Botón de Enviar -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Actualizar Nivel</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>