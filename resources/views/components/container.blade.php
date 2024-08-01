<!--Copio la clase de views navigation-menu.blade.php-->

<!--Si no defino una anchura tomará 7xl-->
@props(['width'=>'7xl'])

@php
    $maxWidth= match($width){
        '4xl'=>'max-w-4xl',
        '5xl'=>'max-w-5xl',
        '6xl'=>'max-w-6xl',
        '7xl'=>'max-w-7xl',
        default=>'max-w-7xl',
    };

@endphp

<!--Mediante el método merge(), ahora cualquier otra clase, que añada en index.blade.php la fusionará con estas.
La anchura será asignada dinamicamente-->
<div {{$attributes->merge(['class'=>$maxWidth . ' mx-auto px-4 sm:px-6 lg:px-8'])}}>
    {{$slot}}
</div>