<div>
    <div class="card">
        <div class="card-body">

            @if(session('info'))
                <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
                    <strong>Éxito! </strong>{{ session('info') }}
                </div>
            @endif
            
            <div class="table-responsive">


                <!-- Contenedor Flex para los botones y el menú desplegable -->
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <form wire:submit.prevent="filterUsers" class="flex items-center relative text-gray-600 space-x-4">
                            <!-- Menú desplegable para seleccionar un único rol -->
                            <select wire:model="selectedRoles" class="h-10 border-gray-300 rounded-lg">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filtrar Usuarios por Rol
                            </button>
                        </form>
                    </div>

                    @if (session('warning'))
                        <div class="bg-yellow-500 text-white px-4 py-2 w-full shadow-md mb-2">
                            <strong>Advertencia! </strong>{{ session('warning') }}
                        </div>
                    @endif

                    <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Crear Nuevo Usuario
                    </a>
                </div>





                <form  class="pt-2 relative mx-auto text-gray-600" autocomplete="off">
                    <input  wire:model.live="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                           type="search" name="search" placeholder="Escribe un nombre o un email....">
            


                    @if ($search != "")
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nombre</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones -->
                                </tr>
                            </thead>
                                <tbody>
                                    @forelse ($filteredUsersBySearch as $user)
                                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"> <!-- Alternar colores entre filas -->
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
                                            <td colspan="4" class="border px-4 py-2 text-center">No hay Usuario que coincida con su búsqueda</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $filteredUsersBySearch->links() }}
                        </div>
                    @else
                        @if ($selectedRoles!=null)
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones -->
                                    </tr>
                                </thead>
                                    <tbody>
                                        @forelse ($filteredUsersByRoles as $user)
                                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"> <!-- Alternar colores entre filas -->
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
                                                <td colspan="3" class="border px-4 py-2 text-center w-full">No hay ningún rol registrado</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $filteredUsersByRoles->links() }}
                            </div>
                        @else
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2 text-center">Acciones</th> <!-- Centrar el texto de Acciones -->
                                    </tr>
                                </thead>
                                    <tbody>
                                        @forelse ($allUsers as $user)
                                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"> <!-- Alternar colores entre filas -->
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
                                                <td colspan="3" class="border px-4 py-2 text-center w-full">No hay ningún rol registrado</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $allUsers->links() }}
                            </div>
                        @endif
                    @endif
                </form>
            </div>
        </div>
    </div>


    
    

</div>






