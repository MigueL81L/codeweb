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

    <div class="h-screen">

        <div class="card-body">
            <div class="table-responsive">
                <table class="mx-auto sm:w-full">
                    <thead>
                        <tr>
                            <th class="w-1/3 px-4 py-2 text-center">Nombre</th>
                            <th class="w-2/3 px-4 py-2 text-center">Permisos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles->sortByDesc('id') as $role)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $role->name }}</td>

                                <td class="border px-4 py-2 text-center relative">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="togglePermissions(this)">
                                        Ver Permisos
                                    </button>
                                </td>
                            </tr>
                            <tr class="w-full hidden">
                                <td colspan="2" class="p-0">
                                    <ul class="bg-white text-gray-800 shadow-lg z-50 rounded-lg w-full grid grid-cols-2">
                                        @foreach($role->permissions as $permission)
                                            <li class="px-4 py-2 text-base font-semibold text-center">{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="border px-4 py-2 text-center">No hay ningún rol registrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function togglePermissions(button) {
            const row = button.closest('tr').nextElementSibling; // El tr que contiene la lista de permisos
            row.classList.toggle('hidden'); // Alterna la visibilidad de la fila de permisos

            // Cierra otras filas de permisos abiertas
            document.querySelectorAll('tr.w-full').forEach(tr => {
                if (tr !== row && !tr.classList.contains('hidden')) {
                    tr.classList.add('hidden');
                }
            });
        }

        // Close all permissions panels when clicking elsewhere on the page
        document.addEventListener('click', function(event) {
            if (!event.target.closest('table')) {
                document.querySelectorAll('tr.w-full').forEach(tr => tr.classList.add('hidden'));
            }
        });
    </script>

</x-admin-layout>
