<x-instructor-layout>
    <!--Cabecera-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center md:text-left">
            Editar Curso: {{ $course->title }}
        </h2>
    </x-slot>

    <!--Llamo al componente, le paso la información del curso, y coloco dentro algo, en este caso un formulario-->
    <!--El componente course-sidebar aplica código del componente x-container-->
    <x-instructor.course-sidebar :course="$course">
        <form action="{{ route('instructor.courses.update', $course) }}"
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <p class="text-2xl font-semibold text-center">Información del Curso</p>
            <hr class="mt-2 mb-6">

            <!--Componente que me muestra todos los posibles errores de validación-->
            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label value="Título del Curso" class="mb-1 font-semibold"/>
                <x-input id="title" class="w-full " value="{{ old('title', $course->title) }}" name="title"/>
            </div>

            @empty($course->published_at)
                <div class="mb-4">
                    <x-label value="Slug del Curso" class="mb-1 font-semibold"/>
                    <x-input id="slug" class="w-full " value="{{ old('slug', $course->slug) }}" name="slug"/>
                </div>
            @endempty

            <div class="mb-4 ckeditor">
                <x-label value="Descripción" class="mb-1 font-semibold"/>
                <x-textarea id="editor" class="w-full " name="description">{{ old('description', $course->description) }}</x-textarea>
            </div>

            <div class="mb-4">
                <x-label value="Resumen" class="mb-1 font-semibold"/>
                <x-textarea class="w-full " name="summary">{{ old('summary', $course->summary) }}</x-textarea>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div>
                    <x-label class="mb-1">Categorías</x-label>
                    <x-select name="category_id" class="w-full">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id)==$category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label class="mb-1">Niveles</x-label>
                    <x-select name="level_id" class="w-full">
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('level_id', $course->level_id)==$level->id)>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label class="mb-1">Precios</x-label>
                    <x-select name="price_id" class="w-full">
                        @foreach ($prices as $price)
                            <option value="{{ $price->id }}" @selected(old('price_id', $course->price_id)==$price->id)>
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

            <div>
                <p class="text-2xl font-semibold mb-2 text-center">Imagen del Curso</p>
                <div class="grid md:grid-cols-2 gap-4">
                    <figure>
                        <img id="imgPreview" src="{{ $course->image }}" alt="Imagen del Curso" class="w-full aspect-video object-cover object-center">
                    </figure>
                    <div>
                        <p class="mt-8 mb-4">Aqui podrás cambiar la foto del curso</p>
                        <label>
                            <span class="btn btn-blue flex justify-center md:hidden cursor-pointer">Seleccionar una imagen</span>
                            <input 
                                type="file" 
                                accept="image/*"
                                name="image" 
                                class="mb-4 hidden md:block"
                                onchange="preview_image(event, '#imgPreview')">
                        </label>
                        <div class="flex justify-center md:justify-end mt-4">
                            <x-button>
                                Guardar Cambios
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-instructor.course-sidebar>
    
    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>
        
        <script>
            function preview_image(event, querySelector) {
                var reader = new FileReader();
                reader.onload = function(){
                    var output = document.querySelector(querySelector);
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>

        {{-- JavaScript para actualizar el campo slug basado en el título --}}
        <script>
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




