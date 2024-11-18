{{-- <x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Lista de Roles',
        'url' => route('admin.roles.index'),
    ]
]"
>

    @if(session('info'))
        <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
            <strong>Éxito! </strong>{{ session('info') }}
        </div>
    @endif

    <div >

        <div class="card-body">
            <div class="table-responsive">

                <div class="flex items-center sm:justify-start py-4">
                    <a class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-8 rounded text-center" href="{{ route('admin.roles.create') }}">
                        Crear Rol
                    </a>
                </div>

                <table class="mx-auto sm:w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Nombre</th>
                            <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones --> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $role->name }}</td> 
                                
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('admin.roles.edit', $role) }}">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded inline-block">
                                            Editar
                                        </button>
                                    </a>
                                    
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta Rol?')"  class="inline-block ml-2">
                                        @method('delete')
                                        @csrf
                                        
                                        <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded inline-block mt-2 mr-1 sm:mt-0 sm:mr-0" type="submit">Eliminar</button> <!-- Ajusta la anchura -->
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center">No hay ningún rol registrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout> --}}

<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Lista de Roles',
        'url' => route('admin.roles.index'),
    ]
]">

    <div>

        <div class="card-body">
            <div class="table-responsive">

                <div class="flex items-center sm:justify-start py-4">
                    <a class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-8 rounded text-center" href="{{ route('admin.roles.create') }}">
                        Crear Rol
                    </a>
                </div>

                <table class="mx-auto sm:w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Nombre</th>
                            <th class="px-4 py-2 text-center">Permisos</th> <!-- Título Cambiado a Permisos -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $role->name }}</td> 
                                
                                <td class="border px-4 py-2 text-center">
                                    <div x-data="{ open: false }" class="relative">
                                        <select @click="open = !open" class="h-10 w-full border-gray-300 rounded-lg bg-gray-800 text-white cursor-default" @focus="open = true" @blur="open = false">
                                            <option value="" class="py-2">Permisos de {{ $role->name }}</option>
                                            <template x-show="open">
                                                @foreach($role->permissions as $permission)
                                                    <option value="{{ $permission->id }}" class="bg-gray-800 text-white">{{ $permission->name }}</option>
                                                @endforeach
                                            </template>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center">No hay ningún rol registrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-admin-layout>
