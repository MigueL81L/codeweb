@php /*
   
   <x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Edición de Usuario',
        'url' => '#',
    ]
]">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del User -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Usuario</label>
                    {{--Por defecto aparece el nombre el rol, previo a su edición--}}
                    <input type="text" name="name" id="name" placeholder="Escriba un nombre" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $user->name) }}">

                    {{-- @error('name')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror --}}
                </div>

                <!-- Email del User -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email del Usuario</label>
                {{--Por defecto aparece el nombre el rol, previo a su edición--}}
                    <input type="email" name="email" id="email" placeholder="Escriba un email" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('email', $user->email) }}">
                
                    {{-- @error('email')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror --}}
                </div>

                <!-- Roles del User -->
                <div class="mb-4">
                    <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                    @foreach($roles as $role)
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                            {{--Recorro el array de roles, y si alguno corresponde con los del user, lo checkeo, en caso contrario, no--}}
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-checkbox h-5 w-5 text-blue-600" {{ in_array($role->id, $selectedRoles) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                            </label>
                        </div>
                    @endforeach
                                
                        {{-- @error('roles')
                            <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                        @enderror --}}
                </div>



                <!-- Botón de Enviar -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>



</x-admin-layout> */
@endphp