<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('public/Logo64.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!--Coloco mi kit de fuentes de FontAwesome-->
        <script src="https://kit.fontawesome.com/9ff47718a2.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link rel="stylesheet" href="{{ asset('build/assets/app-KEcVs8Hg.css') }}">
        <script src="{{ asset('build/assets/app-49Ykkm2g.js') }}" defer></script>

        <!-- Styles -->
        @livewireStyles

        <!--Stack para incluir el reproductor de lyr.io-->
        @stack('css')
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            {{-- @include('layouts.includes.instructor.navigation-menu') --}}
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
            <main class="mb-8">
                {{ $slot }}
            </main>

            {{-- @include('layouts.includes.instructor.footer') --}}
            @include('layouts.includes.app.footer')
        </div>

        @stack('modals')

        @livewireScripts

        <!--cdn de sweetalert2-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('swal', data=>{
                Swal.fire(data[0]);
            });
        </script>

        <!--En el futuro le pasaré código y quiero que lo coloque aqui-->
        @stack('js')
    </body>
</html>