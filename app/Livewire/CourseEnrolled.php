<?php

namespace App\Livewire;

//Paquete carrito de compra traido de github
use CodersFree\Shoppingcart\Facades\Cart;  
use Livewire\Component;

class CourseEnrolled extends Component
{
    public $course;

    //Método para añadir items al carrito
    public function addCart(){
        //Almaceno la compra=>Cart, en una instancia predefinida
        Cart::instance('shopping');
        Cart::add([
            'id'=>$this->course->id,
            'name'=>$this->course->title,

            //Hay que ver este parámetro como se define
            'qty'=>1,
            'price'=>$this->course->price->value,

            //Si se quieren pasar más parámetros hay que pasarselos mediante options, y un array
            'options'=>[
                'slug'=>$this->course->slug,
                'image'=>$this->course->image,
                'teacher'=>$this->course->teacher->name,
            ]
        ]);

        //Añado evento que se disparará, y contará el item añadido al carrito
        $this->dispatch('cart-updated', Cart::count());
    }

    //Método para eliminar un item del carrito
    public function removeCart(){

        //Defino la instancia en la que quiero trabajar, y luego elimino el course de esa instancia,
        //que viene siendo la colección de courses agregados al carrito
        Cart::instance('shopping');
        $itemCart=Cart::content()->where('id', $this->course->id)->first();

        if($itemCart){
            //Si existe el item en el carrito, lo elimina
            Cart::remove($itemCart->rowId);
        }
        //Si no existe el item en el carrito, no hace nada

        //Añado evento que se dispará y restará item del carrito
        $this->dispatch('cart-updated', Cart::count());
    }

    public function buyNow(){
        //Si es que el item estaba en el carrito, y le di a Comprar Ya, primero lo elimino, para que no duplique
        $this->removeCart();

        //El item nunca existió/ya no existe en el carrito, entonces lo agrega
        $this->addCart();

        return redirect()->route('cart.index');
    }

    public function enrolled(){
        //Esta el usuario autenticado?
        if(auth()->check()){
            //Compra el curso y matricúlate
            $this->course->students()->attach(auth()->user()->id);
            //El curso ya está comprado, por tanto eliminalo del carrito
            $this->removeCart();
        }
        return redirect()->route('courses.status', $this->course);
    }


    public function render()
    {

        return view('livewire.course-enrolled');
    }
}
