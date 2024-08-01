
<!--La información de breadcrumb, se la pasaré a la hora de llamar a la plantilla, en caso vacío, 
    almacenaré un array vacío-->
    @props(['breadcrumb' => []])



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
  

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!--Coloco mi kit de fuentes de FontAwesome-->
    <script src="https://kit.fontawesome.com/9ff47718a2.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<!--Nomenclatura Alpine->x-data. Introduzco la variable open, cuyo valor cambiará con el click-->
{{--Si le pongo false, estando en pantalla grande no me muestra el sidebar--}}
<body x-data="{
    open:true,
}"

:class="{
    'overflow-hidden':open,
}"

class="sm:overflow-auto">
    
<!--Si el menú está abierto, la barra de scroll desaparece-, (es lo anterior)-->

    {{--Para que las páginas de admin, home, ..etc, usen el mismo navigation-menu--}}
    @livewire('navigation-menu')

   {{-- @include('layouts.includes.admin.navigation') --}}
   @include('layouts.includes.admin.sidebar')


  
  <div class="p-4 sm:ml-64">

    <!--Aplicación de las migas de pan-->
        <div class=" mt-14">
            @include('layouts.includes.admin.breadcrumb')
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    {{$slot}}
                </div>
        </div>
  </div>

  <div 
  x-cloak
  x-show="open" 
  x-on:click="open = false"
  class="bg-gray-900 bg-opacity-50 fixed inset-0 z-30 sm:hidden">
    
  </div>
  
  @stack('modals')

  @livewireScripts


</body>
</html>