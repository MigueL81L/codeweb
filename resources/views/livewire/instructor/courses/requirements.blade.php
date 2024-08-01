<div>
    <!--Verifico que haya elementos en el array $goals-->
    @if (count($requirements))

        <ul class="space-y-2 mb-4" id="requirements">
            @foreach ($requirements as $index=>$requirement)
                <li wire:key="requirement-{{$requirement['id']}}" data-id="{{$requirement['id']}}">
                    <div class="flex">
                        <x-input wire:model="requirements.{{$index}}.name" class="flex-1 rounded-r-none"/>
                        <div class="flex border border-l-0 border-gray-300 divide-x divide-gray-300 rounded-r">
                            
                                <button onclick="destroyRequirement({{$requirement['id']}})" class="px-2 hover:text-red-500">
                                    <!--Incono de elminación de la meta-->
                                    <i class="far fa-trash-alt"></i>
                                </button>

                                <div class="flex items-center px-2 cursor-move "> 
                                    <i class="fas fa-bars"></i>
                                </div>
                            
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <!--Mantente a la escucha del evento click, y cuando suceda ejecuta el método update-->
        <div class="flex justify-end mb-8">
            <x-button wire:click="update">Actualizar</x-button>
        </div>
        
    @endif



    <!--Mantente a la escucha del evento submit, y cuando suceda esto, ejecuta el método store-->
    <form wire:submit="store">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6">
            <x-label>
                Nuevo Requisito
            </x-label>

            <!--conecto el input co una propiedad del componente-->
            <x-input wire:model="name" class="w-full" placeholder="Ingresa el nombre del Requisito" />

            <!--Componente creado con jetstream para validar una determinada propiedad-->
            <x-input-error for="name" />

            <div class="flex justify-end mt-4">
                <x-button>
                    Agregar Requisito
                </x-button>
            </div>
        </div>
    </form>

    @push('js')
        <!--cdn de sortable js, para cambiar orden de las metas-->
        <script src="
        https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js">
        </script>

        <!--Implementación función sortable, para lo cual debo crear instancia sortable-->
        <script>
            const requirements=document.getElementById('requirements');
            const sortable= new Sortable(requirements, {
                animation: 150,
                ghostClass: 'blue-background-class',
                store:{
                    set:(sortable)=>{
                        //Método sortGoals previamente implementado en componente livewire Goals.php
                        @this.call('sortRequirements', sortable.toArray());
                    }
                }
            });

            
        </script>

        <script>
            function destroyRequirement(id){
                //Nuevo bloque de alerta copiado de sweetalert2
                Swal.fire({
                    title: "Estás seguro que deseas eliminar la meta?",
                    text: "Tú no podrás dar marcha atrás!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, Eliminala!",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                        title: "Eliminada!",
                        text: "La meta seleccionada ha sido eliminada.",
                        icon: "success"
                        });

                        //LLamo al méto destroy() de Goals.php
                        @this.call('destroy', id);
                    }
                });
            }
        </script>
    @endpush
</div>
