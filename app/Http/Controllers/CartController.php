<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Paquete carrito de compra traido de github
use CodersFree\Shoppingcart\Facades\Cart;  

class CartController extends Controller
{
    public function index(){
        // return view('cart.index');
                // Obtén el contenido del carrito
                $cartContent = Cart::instance('shopping')->content();

                // Retorna la vista con el contenido del carrito
                return view('cart.index', compact('cartContent'));
    }
}
