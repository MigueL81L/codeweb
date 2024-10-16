{{-- Esto va a situarse en views\livewire\instructor\courses\manage-sections.blade.php --}}

<div class="flex items-center justify-between md:flex md:items-center">
    {{-- La clase handle viene del x-init, y es la que va permitir en exclusiva el 
    cambio de posición mediante arrastre de ratón --}}
    <h1 class="md:flex-1 truncate handle cursor-move">
        Sección {{$loop->iteration}}:
        {{-- <br class="md:hidden"> --}}
        <span class="font-semibold">{{$section->name}}</span>
    </h1>

    <div class="space-x-2 md:shrink-0 md:ml-4">
        {{-- Botón Edición --}}
        {{-- Cuando se clicke el botón se ejecutará el metodo edit --}}
        <button wire:click="edit({{$section->id}})">
            <i class="fas fa-edit hover:text-indigo-600"></i>
        </button>

        {{-- Botón Eliminación --}}
        <button x-on:click="destroySection({{$section->id}})">
            <i class="far fa-trash-alt hover:text-red-600"></i>
        </button>

        {{-- Botón para abrir/cerrar acordeón --}}
        <button x-on:click="isOpen = !isOpen" class="bg-transparent border-none cursor-pointer focus:outline-none" title="Mostrar/Ocultar lecciones">
            <i class="fas fa-chevron-down" :class="{'transform rotate-180': isOpen}"></i>
        </button>
    </div>
</div>
