{{--Esto va a situarse en views\livewire\instructor\courses\manage-sections.blade.php--}}

<div x-data="{
    open:false
}">
    <div x-on:click="open = !open"
    class="h-6 w-12 -ml-4 bg-indigo-50 hover:bg-indigo-200 flex items-center justify-center cursor-pointer"
    style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">

        <i class="-ml-2 text-sm fas fa-plus transition duration-300"
            :class="{
                'transform rotate-45': open,
                'transform rotate-0': !open
            }"></i>
    </div>
    {{-- Crear Nueva Sección --}}
    <!-- Mantente a la escucha del evento submit, y cuando suceda esto, ejecuta el método store -->
    <div x-show="open" x-cloack class="mt-6">
        <form wire:submit="store">
                <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                    <x-label>
                        Nueva Sección
                    </x-label>
                    
                    <!-- Conecto el input co una propiedad del componente -->
                    <x-input wire:model="name" class="w-full" placeholder="Ingresa el nombre de la Sección" />

                    <!-- Componente creado con jetstream para validar una determinada propiedad -->
                    <x-input-error for="name" />

                    <div class="flex justify-end mt-4">
                        <x-button>
                            Agregar Sección
                        </x-button>
                    </div>
                </div>
        </form>
    </div>
</div>