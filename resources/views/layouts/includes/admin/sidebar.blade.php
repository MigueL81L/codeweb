@php

$links = [
    [
        'header' => 'Administrar página'
    ],
    [
        'name' => 'Panel de Control',
        'icon' => 'fa-solid fa-gauge',
        'route' => route('admin.dashboard'),
        'active' => request()->routeIs('admin.dashboard') 
    ],
    [
        'name' => 'Lista de Roles',
        'icon' => 'fas fa-user-cog',
        'route' => route('admin.roles.index'),
        'active' => request()->routeIs('admin.roles.index')
    ],
    [
        'name' => 'Lista de Usuarios',
        'icon' => 'fas fa-fw fa-users',
        'route' => route('admin.users.index'),
        'active' => request()->routeIs('admin.users.index')
    ],
    [
        'name' => 'Lista de Categorías',
        'icon' => 'fas fa-tags',
        'route' => route('admin.categories.index'),
        'active' => request()->routeIs('admin.categories.index')
    ],
    [
        'name' => 'Lista de Niveles',
        'icon' => 'fa-solid fa-signal',
        'route' => route('admin.levels.index'),
        'active' => request()->routeIs('admin.levels.index') 
    ],
    [
        'name' => 'Lista de Precios',
        'icon' => 'fas fa-coins',
        'route' => route('admin.prices.index'),
        'active' => request()->routeIs('admin.prices.index')
    ]
];
@endphp

<aside id="logo-sidebar" 
    class="fixed top-16 left-0 z-40 w-64 h-screen pt-10 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    x-show="open" 
    :class="{
        'transform-none': open,
        'translate-x-full': !open
    }"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                @if (
                    (isset($link['name']) && $link['name'] == 'Panel de Control' && Gate::check('Ver dashboard')) ||
                    (isset($link['name']) && $link['name'] == 'Lista de Roles' && Gate::check('Listar role')) ||
                    (isset($link['name']) && $link['name'] == 'Lista de Usuarios' && Gate::check('Leer usuarios')) ||
                    (isset($link['name']) && $link['name'] == 'Lista de Categorías' && Gate::check('Listar categorias')) ||
                    (isset($link['name']) && $link['name'] == 'Lista de Niveles' && Gate::check('Listar niveles')) ||
                    (isset($link['name']) && $link['name'] == 'Lista de Precios' && Gate::check('Listar precios')) ||
                    (!isset($link['name']))
                )
                    <li>
                        @isset($link['header'])
                            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                                {{ $link['header'] }}
                            </div>
                        @else
                            @isset($link['submenu'])
                                <div x-data="{ open: {{$link['active'] ? 'true' : 'false'}} }">
                                    <button class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-100' : ''}}" x-on:click="open=!open">
                                        <span class="inline-flex w-6 h-6 justify-center items-center">
                                            <i class="{{$link['icon']}} text-gray-500"></i>
                                        </span>
                                        <span class="ms-3 text-left flex-1">
                                            {{ $link['name'] }}
                                        </span>
                                        <i class="fa solid fa-angle-down" :class="{ 'fa-angle-down':!open, 'fa-angle-up':open }"></i>
                                    </button>
                                    <ul x-show="open" x-cloak>
                                        @foreach ($link['submenu'] as $item)
                                            <li class="pl-4">
                                                <a href="" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$item['active'] ? 'bg-gray-100' : ''}}">
                                                    <span class="inline-flex w-6 h-6 justify-center items-center">
                                                        <i class="{{$item['icon']}} text-gray-500"></i>
                                                    </span>
                                                    <span class="ms-3 text-left flex-1">
                                                        {{ $item['name'] }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $link['route'] }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-100' : ''}}">
                                    <span class="inline-flex w-6 h-6 justify-center items-center">
                                        <i class="{{ $link['icon'] }} text-gray-500"></i>
                                    </span>
                                    <span class="ms-3">
                                        {{ $link['name'] }}
                                    </span>
                                </a>
                            @endisset
                        @endisset
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>









