<div class="mt-2">
    <div class="card-body">
        @if (session()->has('success'))
            <div class="bg-blue-500 text-white px-4 py-2 w-full shadow-md mb-2">
                <strong>Éxito! </strong>{{ session('success') }}
            </div>
        @endif

        @if ($showForm)
            <h2 class="text-lg font-medium text-gray-700 mb-4 text-center">{{ $isEditing ? 'Editar Reseña' : 'Crear Reseña' }}</h2>
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="text-left">
                <!-- Comentario del Review -->
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700">Comentario</label>
                    <textarea name="comment" id="comment" placeholder="Escriba un comentario" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" wire:model="comment"></textarea>
                    @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Calificación del Review -->
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Calificación</label>
                    <input type="number" name="rating" id="rating" placeholder="Calificación del 1 al 5" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" min="1" max="5" wire:model="rating">
                    @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">{{ $isEditing ? 'Actualizar Reseña' : 'Crear Reseña' }}</button>
                    <button type="button" wire:click="cancel" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-2 ml-2">Cancelar</button>
                </div>
            </form>
        @else
            @if($reviewId)
                {{-- <div>
                    <div class="text-gray-600 mt-2">
                        <h2 class="font-bold">Tu Reseña</h2>

                        <div class="w-full">
                            <h5 class="text-lg font-medium text-gray-700 ml-2">Calificación:</h5>
                            <p class="text-gray-600 ml-5">{{ $rating }}</p>
                        </div>

                        <div class="w-full">
                            <h5 class="text-lg font-medium text-gray-700 ml-2">Comentario:</h5>
                            <p class="text-gray-600 ml-5">{{ $comment }}</p>
                        </div>
                    </div>

                    <div class="flex justify-center space-x-2">
                        <button type="button" wire:click="edit" class="btn btn-secondary font-bold py-2 px-4 rounded mt-2">Editar Reseña</button>
                        <button type="button" wire:click="destroy" class="btn btn-danger font-bold py-2 px-4 rounded mt-2">Eliminar Reseña</button>
                    </div>
                </div> --}}

                <div class="mt-2">
                    <div class="text-gray-600 mt-2">
                        <h2 class="font-bold text-gray-600 text-2xl text-center">Tu Reseña</h2>

                        <div class="text-gray-600 mt-4">
                            <h5 class="text-lg font-bold mr-2">Calificación:</h5>
                            <p >{{ $rating }}</p>
                        </div>
                
                        <div class="text-gray-600 mt-4">
                            <h5 class="text-lg font-bold">Comentario:</h5>
                            <p>{{ $comment }}</p>
                        </div>
                    </div>
                
                    <div class="flex justify-center space-x-2 mt-4">
                        <button type="button" wire:click="edit" class="btn btn-primary btn-blue:hover font-bold py-2 px-4 rounded mt-2">Editar Reseña</button>
                        <button type="button" wire:click="destroy" class="btn btn-danger btn-danger:hover font-bold py-2 px-4 rounded mt-2">Eliminar Reseña</button>
                    </div>
                </div>
                
            @else
                <div class="text-left">
                    <p class="bg-gray-100 text-gray-700 p-4 rounded mb-4">Todavía no has creado una reseña para este curso. ¡Queremos conocer tu experiencia!</p>
                    <button type="button" wire:click="create" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-2">Crear Reseña</button>
                </div>
            @endif
        @endif
    </div>
</div>








