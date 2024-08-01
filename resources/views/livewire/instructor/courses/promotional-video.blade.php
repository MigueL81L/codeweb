<div>
    <!--css reproductor Plyr.io-->
    @push('css')
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @endpush

    <h1 class="text-2xl font-semibold">Video Promocional</h1>
    <hr class="mt-2 mb-6">

    <div class="grid grid-cols-2 gap-6">
        <div class="col-span-1">
            <!--Pregunto si hay vido subido-->

            @if ($course->video_path)
            <!--Si hay video, muestramelo-->
            <!--playsinline controls data-poster id="player" son parámetros del reproductor Plyr.io-->
            <!--Inicializo el vido mediante alpine-->
            <!--Con wire:ignore se especifica que si hay alguna modificación, debe actualizar todo
            menos lo que encierra el div-->
                <div wire:ignore>
                    <div x-data x-init="let player= new Plyr($refs.player);">
                        <video x-ref="player" playsinline controls data-poster="{{$course->image}}" class="aspect-video">
                            <source src="{{Storage::url($course->video_path)}}" >
                        </video>  
                    </div>  
                </div>
            @else
            <!--Si no hay video muestrame la imagen del curso-->
                <figure>
                    <img class="w-full aspect-video object-cover" src="{{$course->image}}" alt="{{$course->title}}">
                </figure>
            @endif
        </div>

        <div class="col-span-1">
            <form wire:submit="save">

                <x-validation-errors />

                <p class="mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam maiores laborum quam quos omnis! 
                    Recusandae maiores perspiciatis quis provident nemo tenetur quibusdam corporis optio commodi odio, 
                    officia vel numquam minima.
                </p>
                <!--Componente de barra de progresos, previamente implementada en un componente, y cuyo código procede de
                    livewire3-->
    
                <x-progress-indicators wire:model="video"/>
    
                <div class="flex justify-end mt-4">
                    <x-button>
                        Subir Video
                    </x-button>
                </div>
            </form>
            
        </div>
    </div>
    <!--js para el reproductor Plyr.io-->
    @push('js')
        <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    @endpush
</div>
