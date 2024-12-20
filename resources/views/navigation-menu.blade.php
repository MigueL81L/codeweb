
@php
    $links=[ 
        [
            'name'=>'Home',
            'route'=>route('home'),
            'active'=>request()->routeIs('home'),  
        ],

        //Agregar también el link
        [
            'name'=>'Cursos',
            'route'=>route('courses.index'),
            //Al poner asterisco, cualquier ruta que empiece por courses, hará que esté activo
            'active'=>request()->routeIs('courses.index'), 
        ],
        //Agregar también el link
        [
            'name'=>'Tus Cursos',
            'route'=>route('courses.matriculados'),
            //Al poner asterisco, cualquier ruta que empiece por courses, hará que esté activo
            'active'=>request()->routeIs('courses.matriculados'), 
        ],
        //Agregar también el link
        [
            'name'=>'Creación de Cursos',
            'route'=>route('instructor.courses.index'),
            //Al poner asterisco, cualquier ruta que empiece por courses, hará que esté activo
            'active'=>request()->routeIs('instructor.courses.*'), 
        ],
        [
            'name'=>'Panel de Control',
            'route'=>route('admin.dashboard'),
            //Al poner asterisco, cualquier ruta que empiece por courses, hará que esté activo
            'active'=>request()->routeIs('admin.*'),
            'can' => 'Ver dashboard'
        ]

    ];
@endphp



<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- Primary Navigation Menu, con clase definida en commom.css -->
    <div class="container">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo and Application name -->
                <div class="shrink-0 flex items-center">  
                    <x-application-mark class="block h-9 w-auto" />
                </div>
                

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @foreach ($links as $item)

                        @php
                            $canView = false; // Por defecto, no mostrar el enlace

                            if (Auth::check()) {
                                switch ($item['name']) {
                                    case 'Panel de Control':
                                        $canView = Auth::user()->hasPermissionTo('Ver dashboard');
                                        break;
                                    case 'Creación de Cursos':
                                        $canView = Auth::user()->hasPermissionTo('Actualizar cursos');
                                        break;
                                    case 'Tus Cursos':
                                        $canView=!$canView;
                                        break;
                                    default:
                                        $canView = true; // Para otros enlaces, siempre mostrar
                                        break;
                                }
                            }
                        @endphp

                        @if ($canView)
                            <x-nav-link href="{{ $item['route'] }}" :active="$item['active']"> 
                                {{ $item['name'] }}
                            </x-nav-link>
                        @endif

                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:space-x-4">

                <!-- Cart Icon -->
                <div class="relative"
                    x-data="{
                        count: {{Cart::instance('shopping')->count() }} 
                    }"
                    x-on:cart-updated.window="count= $event.detail[0]">
                    <!--Escuchando en alpine un evento definido en livewire-->
                    <!--$event.detail[0] es el número de items contenidos en el carrito-->

                    <a href="{{route('cart.index')}}">
                        <i class="fa-solid fa-cart-shopping text-2xl text-gray-600"></i>

                        <!--si count es =0, es como si fuera false-->
                        <span 
                            x-show="count" 
                            x-text="count"
                            class="absolute -top-7 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-blue-100 bg-blue-500 rounded-full">

                        </span>
                    </a>
                </div>



                <!-- Settings Dropdown. Acordeón del perfil -->
                <div class="ms-4 relative">
                    @auth
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition ml-4">
                                            <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/app/public/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <span class="inline-flex rounded-md">
                                            <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition ml-4">
                                                <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <span class="font-semibold text-gray-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                                </div>
                                            </button>
                                        </span>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>


                                    <div class="border-t border-gray-200"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>

                    @else

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-600">
                                        <i class="fa-regular fa-circle-user text-2xl"></i>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <!--Las rutas login y register se crearon por defecto con jetstream-->
                                    <x-dropdown-link href="{{ route('login') }}">
                                        Iniciar Sesión
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('register') }}">
                                        Registrarse
                                    </x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                    @endauth

                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="flex flex-col items-center py-2 border-t border-gray-200">
            <div class="flex items-center w-full justify-between">
                <div class="flex items-center">
                    <!-- Navigation Links -->
                    @foreach ($links as $item)
                        @php
                            $canView = false; 

                            if (Auth::check()) {
                                switch ($item['name']) {
                                    case 'Panel de Control':
                                        $canView = Auth::user()->hasPermissionTo('Ver dashboard');
                                        break;
                                    case 'Creación de Cursos':
                                        $canView = Auth::user()->hasPermissionTo('Eliminar cursos');
                                        break;
                                    case 'Tus Cursos':
                                        $canView = true; // Asegúrate que para estudiantes esté siempre visible
                                        break;
                                    default:
                                        $canView = true;
                                        break;
                                }
                            }
                        @endphp

                        @if ($canView)
                            @php
                                // Verificamos si el usuario autenticado tiene el rol de estudiante
                                $isStudent = auth()->user()->hasRole('Estudiante');
                            @endphp

                            @if ($isStudent)
                                <x-responsive-nav-link-estudiante href="{{ $item['route'] }}" :active="$item['active']">
                                    {{ $item['name'] }} 
                                </x-responsive-nav-link-estudiante>
                            @else
                                <x-responsive-nav-link href="{{ $item['route'] }}" :active="$item['active']">
                                    {{ $item['name'] }} 
                                </x-responsive-nav-link>
                            @endif
                        @endif
                    @endforeach
                </div>

                <!-- User Icon Button and Cart Icon -->

                <div class="flex flex-col items-center mr-4">

                    <div class="ms-4 relative me-2">
                        @auth
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/app/public/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                    <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <span class="font-semibold text-gray-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                                    </div>
                                                </button>
                                            </span>
                                        @endif
                                    </x-slot>
    
                                    <x-slot name="content">
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Account') }}
                                        </div>
    
                                        <x-dropdown-link href="{{ route('profile.show') }}">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>
    
    
                                        <div class="border-t border-gray-200"></div>
    
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
    
                                            <x-dropdown-link href="{{ route('logout') }}"
                                                    @click.prevent="$root.submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
    
                        @else
    
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="text-gray-600">
                                            <i class="fa-regular fa-circle-user text-2xl"></i>
                                        </button>
                                    </x-slot>
    
                                    <x-slot name="content">
                                        <!--Las rutas login y register se crearon por defecto con jetstream-->
                                        <x-dropdown-link href="{{ route('login') }}">
                                            Iniciar Sesión
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('register') }}">
                                            Registrarse
                                        </x-dropdown-link>
    
                                    </x-slot>
                                </x-dropdown>
                        @endauth
    
                    </div>



                    <!-- Cart Icon -->
                    <div class="ms-4 relative mt-2 me-2"
                        x-data="{
                            count: {{Cart::instance('shopping')->count() }} 
                        }"
                        x-on:cart-updated.window="count= $event.detail[0]"> 

                        <a href="{{route('cart.index')}}">
                            <i class="fa-solid fa-cart-shopping text-xl text-gray-600"></i>
                            <span 
                                x-show="count" 
                                x-text="count"
                                class="absolute -top-6 -left-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-blue-100 bg-blue-500 rounded-full">
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </div>    
    </div>

</nav>



