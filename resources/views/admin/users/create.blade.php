<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Creación de Usuario',
        'url' => route('admin.users.create'), 
    ]
]">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nombre del Usuario -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Usuario</label>
                    <input type="text" name="name" id="name" placeholder="Escriba un nombre" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name') }}">
                </div>

                <!-- Email del Usuario -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email del Usuario</label>
                    <input type="email" name="email" id="email" placeholder="Escriba un email" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('email') }}">
                </div>

                <!-- Roles del Usuario -->
                {{-- <div class="mb-4">
                    <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                    @foreach($roles as $role)
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div> --}}
                <!-- Roles del Usuario -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="role" id="role" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->name == "Estudiante" ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Contraseña del Usuario -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Escriba una contraseña" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Botón de Enviar -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
