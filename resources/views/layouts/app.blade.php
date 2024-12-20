<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- Favicon -->
         <link rel="icon" href="{{ asset('public/img/logo/Logo64.png') }}" type="image/png">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!--Coloco mi kit de fuentes de FontAwesome-->
        <script src="https://kit.fontawesome.com/9ff47718a2.js" crossorigin="anonymous"></script>

        <!-- Scripts Importación de estilos, entre otros de tailwind-->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link rel="stylesheet" href="{{ asset('build/assets/app-KEcVs8Hg.css') }}">
        <script src="{{ asset('build/assets/app-49Ykkm2g.js') }}" defer></script>

        <!--Importo la librería del plugin fontawesome-free de adminlte para las estrillitas del rating-->
        <link rel="stylesheet" href="{{asset('./vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css')}}">

        <!-- Styles -->
        @livewireStyles

        <!--cdn SweetAlert para preguntar en una eliminación-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="bg-gray-100">
            {{-- @livewire('navigation-menu') --}} 
            @include('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main> 

            @include('layouts.includes.app.footer')
            
        </div>

        @stack('modals')

        @livewireScripts

        <!--Script de ajuste de texto en caja de selección de los filtros, para la lista de courses, y courses matriculados,  para las pantallas móviles-->
        <!--Texto más pequeño que coja en las pantallas móviles-->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Función para ajustar el texto de los selects
                function adjustSelectText() {
                    const width = window.innerWidth;
        
                    // Cambiar solo para tamaños de pantalla pequeños
                    if (width < 640) {
                        document.getElementById('selectedCategories').options[0].text = "Categoría"; 
                        document.getElementById('selectedPrices').options[0].text = "Precio";
                        document.getElementById('selectedLevels').options[0].text = "Nivel";
                    } else {
                        document.getElementById('selectedCategories').options[0].text = "Seleccione una Categoría";
                        document.getElementById('selectedPrices').options[0].text = "Seleccione un Precio";
                        document.getElementById('selectedLevels').options[0].text = "Seleccione el Nivel";
                    }
                }
        
                // Ejecutar la función al cargar la página y al cambiar el tamaño de la ventana
                adjustSelectText();
                window.addEventListener('resize', adjustSelectText);
            });
        </script>
        
    </body>
</html>
