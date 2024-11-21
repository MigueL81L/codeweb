<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Editar un Rol',
        'url'=>'#'
    ]
]">



    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del Rol -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
                    {{--Por defecto aparece el nombre el rol, previo a su edición--}}
                    <input type="text" name="name" id="name" placeholder="Escriba un nombre" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $role->name) }}">

                    @error('name')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Título de Permisos -->
                <div class="mb-4">
                    <label for="permissions" class="block text-sm font-medium text-gray-700">Permisos</label>
                    @foreach($permissions as $permission)
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                {{--Recorro el array de permisos, y si alguno corresponde con los del rol, lo checkeo, en caso contrario, no--}}
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-checkbox h-5 w-5 text-blue-600" {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
                            </label>
                        </div>
                    @endforeach
                
                    @error('permissions')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="mb-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <!-- Botón de Enviar -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2 sm:mb-0">Actualizar Rol</button>

                     <!-- Botón de Cancelar -->
                    <button type="button" onclick="window.location='{{ route('admin.roles.index') }}'" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>