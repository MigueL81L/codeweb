@props(['breadcrumb' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            body {
                margin: 0; /* Elimina márgenes por defecto */
                overflow: hidden; /* Evita que el contenido se desborde */
                height: 100vh; /* Altura completa de la ventana visible */
                width: 100vw; /* Anchura completa de la ventana visible */
            }

            #app {
                display: flex;
                flex-direction: column;
                height: 100%; /* Mantiene contenido dentro de la ventana */
            }
        </style>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('public/Logo64.png') }}" type="image/png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/9ff47718a2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('build/assets/app-BtxJ_aVk.css') }}">
        <script src="{{ asset('build/assets/app-BDXrVzKj.js') }}" defer></script>
        @livewireStyles
    </head>

    <body x-data="sidebarData()" x-init="checkWidth()"
        @resize.window="checkWidth()">

        <div id="app">
            @include('navigation-menu')

            <div class="flex border-b border-gray-200">
                <div class="flex-none">
                    @include('layouts.includes.admin.sidebar')
                </div>

                <div class="flex-grow p-4 border-l border-gray-200 w-full mt-8">
                    <button @click="toggleSidebar()" class="m-4 p-2 bg-gray-800 text-white sm:hidden">
                        <i :class="open ? 'fas fa-bars' : 'fa-solid fa-gauge'"></i>
                        <span class="ml-2">Barra de Administración</span>
                    </button>

                    @include('layouts.includes.admin.breadcrumb')

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mb-4">
                        {{$slot}}
                    </div>
                </div>
            </div>

            @include('layouts.includes.app.footer')
        </div>

        @stack('modals')
        @livewireScripts
        <script>
            function checkOrientation() {
                if (window.innerHeight < window.innerWidth) {
                    // Si está en apaisado, prevenir ajustes del layout
                    alert('Por favor, utiliza la pantalla en vertical para una mejor experiencia.');
                    window.scrollTo(0, 0); // Vuelve el scroll a la parte superior
                }
            }

            // Registrar el evento de cambio de orientación
            window.addEventListener('resize', checkOrientation);
            window.addEventListener('orientationchange', checkOrientation);
            window.addEventListener('load', checkOrientation);
        </script>
        <script>
            function sidebarData() {
                return {
                    open: false,
                    toggleSidebar() {
                        this.open = !this.open;
                        console.log('Sidebar open status:', this.open); // Agrega este log para seguimiento
                    },
                    checkWidth() {
                        this.open = window.innerWidth >= 768;
                        console.log('Checking Width. Sidebar Open:', this.open);
                    }
                }
            }
        </script>
    </body>
</html>







    



