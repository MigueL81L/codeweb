<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Rol Actualizado',
        'url'=>'#'
    ]
]">

@if(Session::has('info'))
    <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
        <strong>Éxito! </strong>{{ Session::get('info') }}
    </div>
@endif


    <div class="card">
        <div class="card-body">
            <form method="POST"  enctype="multipart/form-data">
                @csrf

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

                <!-- Botón de Enviar -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Actualiar Rol</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>