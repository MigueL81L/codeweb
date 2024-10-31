<div>
    <div x-data="{
        destroySection(sectionId) {
            console.log('Section ID:', sectionId); // Añadido para depuración
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, elimínalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', sectionId);
                }
            });
        }
        }" x-init="
            new Sortable($refs.sections, {
                animation: 150,
                handle: '.handle',
                ghostClass: 'blue-background-class',
                store: {
                    set: (sortable) => {
                        @this.call('sortSections', sortable.toArray());
                    }
                }
            });
        ">
        {{-- Listar Secciones --}}
        @if ($sections->count())
            <ul class="mb-6 space-y-6" x-ref="sections">
                @foreach ($sections as $section)
                    {{-- Llave de seguimiento de livewire en li hijo de foreach --}}
                    <li data-id="{{$section->id}}" wire:key="section-{{$section->id}}" x-data="{ isOpen: false }"> <!-- 1. Propiedad x-data añadida aquí -->
                        
                        {{-- Código alojado en otra vista, para que sea más legible, al no concentrar tanto código en la misma vista --}}
                        @include('instructor.sections.create-position')
                        
                        <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4 mt-6">
                            @if ($sectionEdit['id'] == $section->id)
                                {{-- Código alojado en otra vista, para que sea más legible, al no concentrar tanto código en la misma vista --}}
                                @include('instructor.sections.edit')
                            @else
                                {{-- Código alojado en otra vista, para que sea más legible, al no concentrar tanto código en la misma vista --}}
                                @include('instructor.sections.show')
                            @endif

                            {{-- 3. Div controlado por isOpen añadido aquí --}}
                            <div class="mt-4" x-show="isOpen" x-cloak>
                                {{-- Manejador de lecciones en cada sección --}}
                                @livewire('instructor.courses.manage-lessons', [
                                    'section' => $section,
                                    'lessons' => $section->lessons,
                                    'orderLessons' => $orderLessons,
                                ], key('section-lessons-' . $section->id . '-' . $orderLessons->join('-')))
                            </div>
                        </div> 
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Código alojado en otra vista, para que sea más legible, al no concentrar tanto código en la misma vista --}}
        @include('instructor.sections.create')
    </div>

    @push('js')
        <!-- cdn de sortable js, para cambiar el orden de las sections -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @endpush
</div>


