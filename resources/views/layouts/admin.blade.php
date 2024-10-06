@props(['breadcrumb' => []])

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
        <link rel="stylesheet" href="{{ asset('build/assets/app-BtxJ_aVk.css') }}">
        <script src="{{ asset('build/assets/app-BDXrVzKj.js') }}" defer></script>

        <!-- Styles -->
        @livewireStyles
    </head>

    <body x-data="sidebarData()" x-init="checkWidth()"
        @resize.window="checkWidth()"
        class="sm:overflow-auto"
        :class="{'overflow-hidden': open}">

        {{-- Para que las páginas de admin, home, ..etc, usen el mismo navigation-menu --}}
        {{-- @livewire('navigation-menu')    --}}
        @include('navigation-menu')


        @include('layouts.includes.admin.sidebar')

        <button @click="toggleSidebar()" class="m-4 p-2 bg-gray-800 text-white sm:hidden">
            <i :class="open ? 'fas fa-bars' : 'fa-solid fa-gauge'"></i>
            <span class="ml-2">Barra de Administración</span>
        </button>

        <div class="p-4 sm:ml-64">
            <!--Aplicación de las migas de pan-->
            <div class="mt-16">
                @include('layouts.includes.admin.breadcrumb')
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    {{$slot}}
                </div>
            </div>
        </div>

        <div x-cloak x-show="open" x-on:click="open = false" class="bg-gray-900 bg-opacity-50 fixed inset-0 z-30 sm:hidden"></div>

        @stack('modals')

        @livewireScripts

    </body>
    <script>
        function sidebarData() {
            return {
                open: open,
                toggleSidebar() {
                    this.open = !this.open;
                },
                checkWidth() {
                    this.open = window.innerWidth >= 768;
                }
            }
        }
    </script>
    

</html>



    



