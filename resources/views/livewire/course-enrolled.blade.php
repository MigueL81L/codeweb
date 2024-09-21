
<div>

    <!--Consulta la colección de courses presente en la instancia 'shoppig', 
    si es que existe algún course, agregado al carrito, cuyo id coincide-->

    <!--Carrito-->
    @if (Cart::instance('shopping')->content()->where('id', $course->id)->first())
        <button 
            wire:key="removeCart"
            wire:click="removeCart"
            class="btn btn-blue w-full uppercase mb-2"> 
                Eliminar de la cesta
        </button>
    @else
        <button 
            wire:key="addCart"
            wire:click="addCart"
            class="btn btn-blue w-full uppercase mb-2">
                Agregar a la cesta
        </button>
    @endif


    <!--Carrito + siguiente nivel -->
        <button 
            wire:key="buyNow"
            wire:click="buyNow"
            class="btn btn-red w-full uppercase">
                Comprar ahora
        </button>
</div>







