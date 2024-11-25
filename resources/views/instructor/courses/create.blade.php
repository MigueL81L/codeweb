<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Curso
        </h2>
    </x-slot>

    <x-container class="mt-12" width="4xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h2 class="text-2xl uppercase text-center mb-4">Complete esta información para crear un nuevo curso</h2>

                <x-validation-errors class="mb-4 text-center"/>

                <div class="mb-4">
                    <x-label class="mb-1">Nombre del Curso</x-label>
                    <x-input 
                        placeholder="Nombre del Curso"
                        class="w-full"
                        name="title"
                        id="title"  {{-- Añadir el id para el JS del slug --}}
                        value="{{ old('title') }}"
                        oninput="string_to_slug(this.value,'#slug')"/>
                </div>

                <div class="mb-4">
                    <x-label class="mb-1">Slug</x-label>
                    <x-input 
                        id="slug"
                        placeholder="Slug del Curso"
                        class="w-full"
                        name="slug"
                        value="{{ old('slug') }}"/>
                </div>

                <div class="grid md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-label class="mb-1">Categorías</x-label>
                        <x-select name="category_id" class="w-full">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-label class="mb-1">Niveles</x-label>
                        <x-select name="level_id" class="w-full">
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" @selected(old('level_id') == $level->id)>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-label class="mb-1">Precios</x-label>
                        <x-select name="price_id" class="w-full">
                            @foreach ($prices as $price)
                                <option value="{{ $price->id }}" @selected(old('price_id') == $price->id)>
                                    @if ($price->value == 0)
                                        Gratis
                                    @else
                                        {{ $price->value }}€ (nivel {{ $loop->index }})
                                    @endif 
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                </div>

                <div class="mb-4">
                    <x-label class="mb-1">Imagen del Curso</x-label>
                    <x-input 
                        type="file"
                        class="w-full"
                        name="image"
                        onchange="preview_image(event, '#imgPreview')"/>
                </div>

                <div class="mb-4">
                    <img id="imgPreview" class="w-full aspect-video object-cover object-center"/>
                </div>


                <div class="flex justify-between">
                    <!-- Botón de Cancelar -->
                    <button type="button" onclick="window.location='{{ route('instructor.courses.index') }}'" class="btn btn-danger">
                        Cancelar
                    </button>
                
                    <!-- Botón de Crear Curso -->
                    <button type="submit" class="btn btn-primary">
                        Crear Curso
                    </button>
                </div>
            </form>
        </div>
    </x-container>

    @push('js')
        <script>
            function preview_image(event, querySelector) {
                // Obtengo la URL temporal
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.querySelector(querySelector);
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }

            function slugify(str) {
                str = str.replace(/^\s+|\s+$/g, ''); // trim
                str = str.toLowerCase();

                // remove accents, swap ñ for n, etc
                var from = "áäâàãåāçčéèëěêíïîìıİńñóöôòõøōșşšťüûùúūÿýźž";
                var to   = "aaaaaaaacceeeeeiiiinooooooosssstuuuuuyyz";
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }

                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes

                return str;
            }

            document.getElementById('title').addEventListener('input', function() {
                document.getElementById('slug').value = slugify(this.value);
            });
        </script>
    @endpush
</x-instructor-layout>
