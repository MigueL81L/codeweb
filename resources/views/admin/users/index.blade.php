<x-admin-layout :breadcrumb="[
    [
        'name' => 'Panel de Control',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Lista de Usuarios',
        'url' => route('admin.users.index'),
    ]
]">



    
    @livewire('admin-users')


</x-admin-layout>
