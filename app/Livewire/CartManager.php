<?php

namespace App\Livewire;

use Livewire\Component;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CartManager extends Component
{
    public function remove($rowId)
    {
        // Elimina el curso del carrito usando su rowId
        Cart::instance('shopping')->remove($rowId);
        // No es necesario emitir un evento aquí porque el componente se re-renderiza automáticamente

        //Añado evento que se disparará, y contará el item añadido al carrito
        $this->dispatch('cart-updated', Cart::count());
    }

    public function checkout()
    {
        // Verifica si el usuario está autenticado
        // if (auth()->check()) {
        if (Auth::check()) {
            $cartContent = Cart::instance('shopping')->content();

            foreach ($cartContent as $item) {
                $courseId = $item->id;
                $course = Course::find($courseId); // Obtener el curso por ID

                if ($course) {
                    // Matricula al usuario en el curso
                    $course->students()->attach(Auth::user()->id);
                }
            }

            // Vaciar el carrito después de la compra
            Cart::instance('shopping')->destroy();

            // Redirigir o emitir un mensaje de éxito
            session()->flash('message', 'Has comprado todos los cursos exitosamente!');
            return redirect()->route('courses.matriculados');
        }

        return redirect()->route('courses.index'); // Redirige si no está autenticado
    }

    public function render()
    {
        $cartContent = Cart::instance('shopping')->content();
        return view('livewire.cart-manager', compact('cartContent'));
    }
}

