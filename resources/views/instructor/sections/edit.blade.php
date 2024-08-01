{{-- Esto va a situarse en views\livewire\instructor\courses\manage-sections.blade.php --}}

<form wire:submit.prevent="update">
    <div class="flex items-center space-x-2">
        <x-label>
            {{-- Variable propia del bucle foreach, que indica la iteración en la que se encuentra --}}
            Sección {{$loop->iteration}}:
        </x-label>
        
        <x-input wire:model="sectionEdit.name" class="flex-1" />
    </div>
    
    <div class="flex justify-end mt-4">
        <div class="space-x-2">
            <x-danger-button wire:click="$set('sectionEdit.id', null)">
                Cancelar
            </x-danger-button>  
            <x-button>
                Actualizar
            </x-button>
        </div>
    </div>
</form>
