{{-- <div>
    <div class="card-body">

        @if(session('info'))
            <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Éxito! </strong>{{ session('info') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Advertencia! </strong>{{ session('warning') }}
            </div>
        @endif

        <div class="table-responsive">

            <!-- Contenedor Flex para los botones y el menú desplegable -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <form wire:submit.prevent="filterUsers" class="flex items-center relative text-gray-600 space-x-4">
                        <!-- Menú desplegable para seleccionar un único rol -->
                        <select wire:model="selectedRoles" class="h-10 border-gray-300 rounded-lg">
                            <option value="">Seleccione un Rol</option> <!-- Mensaje inicial -->
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filtrar Usuarios por Rol
                        </button>
                    </form>
                </div>

                <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Crear Nuevo Usuario
                </a>
            </div>

            <form class="pt-2 relative mx-auto text-gray-600" autocomplete="off">
                <input wire:model.live="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="Escribe un nombre o un email...">

                <table class="w-full border-collapse mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginatedUsers as $user)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $user->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $user->email }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a class="btn btn-secondary inline-block" href="{{ route('admin.users.edit', $user) }}">Editar</a>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center">No hay usuarios que coincidan con su búsqueda</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $paginatedUsers->links() }}
                </div>
            </form>
        </div>
    </div>
</div> --}}



{{-- <div>
    <div>

        @if(session('info'))
            <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Éxito! </strong>{{ session('info') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Advertencia! </strong>{{ session('warning') }}
            </div>
        @endif

        <div class="table-responsive overflow-x-auto"> <!-- Permitir desplazamiento horizontal -->
            
            <!-- Contenedor Flex para los botones y el menú desplegable -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0"> <!-- Cambiado a columna para móviles -->
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-x-4"> <!-- Cambiar disposición a fila en pantallas más grandes -->
                    <form wire:submit.prevent="filterUsers" class="flex items-center relative text-gray-600 space-x-4">
                        <!-- Menú desplegable para seleccionar un único rol -->
                        <select wire:model="selectedRoles" class="h-10 border-gray-300 rounded-lg w-full sm:w-auto">
                            <option value="">Seleccione un Rol</option> <!-- Mensaje inicial -->
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Filtrar Usuarios por Rol
                        </button>
                    </form>
                </div>

                <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
                    Crear Nuevo Usuario
                </a>
            </div>

            <form class="pt-2 relative mx-auto text-gray-600 w-full" autocomplete="off">
                <input wire:model.live="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="Escribe un nombre o un email...">

                <table class="w-full border-collapse mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginatedUsers as $user)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $user->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $user->email }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a class="btn btn-secondary inline-block" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                                    
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center">No hay usuarios que coincidan con su búsqueda</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $paginatedUsers->links() }}
                </div>
            </form>
        </div>
    </div>
</div> --}}

<div>
    <div>
        @if(session('info'))
            <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Éxito! </strong>{{ session('info') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Advertencia! </strong>{{ session('warning') }}
            </div>
        @endif

        <div class="table-responsive overflow-x-auto">
            
            <!-- Contenedor Flex para los botones y el menú desplegable -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0">
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-x-4">
                    <form wire:submit.prevent="filterUsers" class="flex items-center relative text-gray-600 space-x-4">
                        <select wire:model="selectedRoles" class="h-10 border-gray-300 rounded-lg w-full sm:w-auto">
                            <option value="">Seleccione un Rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Filtrar Usuarios por Rol
                        </button>
                    </form>
                </div>

                <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
                    Crear Nuevo Usuario
                </a>
            </div>

            <form class="pt-2 relative mx-auto text-gray-600 w-full" autocomplete="off">
                <input wire:model.live="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="Escribe un nombre o un email...">
                
                <table class="w-full border-collapse mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th> <!-- Cambiar título en la versión tablet/laptop -->
                            <th class="hidden sm:table-cell px-4 py-2 text-center">Acciones</th> <!-- Visible sólo en pantallas más grandes -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginatedUsers as $user)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border px-4 py-2 text-center">{{ $user->name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="block sm:hidden"> <!-- Celda combinada para móviles -->
                                        <div>{{ $user->email }}</div>
                                        <div class="flex justify-center space-x-2 mt-2">
                                            <a class="btn btn-secondary" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block">{{ $user->email }}</div> <!-- Mostrar solo email en pantallas más grandes -->
                                </td>
                                <td class="border px-4 py-2 text-center hidden sm:table-cell"> <!-- Celda de acciones oculta en móviles -->
                                    <a class="btn btn-secondary" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')" class="inline-block">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center">No hay usuarios que coincidan con su búsqueda</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $paginatedUsers->links() }}
                </div>
            </form>
        </div>
    </div>
</div>














