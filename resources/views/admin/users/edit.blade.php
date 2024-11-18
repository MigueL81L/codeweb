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
                    <input type="text" name="name" id="name" placeholder="Escriba un nombre" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $user->name) }}">
                
                    @error('name')
                        <span class="text-red-600 mt-2 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Roles del User -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="role" id="role" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón de Enviar -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
