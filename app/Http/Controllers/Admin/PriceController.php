<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\Gate;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Listar precios')) {
            abort(403, 'Unauthorized action.');
        }

        $prices = Price::all();
        return view('admin.prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear precio')) {
            abort(403, 'Unauthorized action.');
        }

        $prices = Price::all();
        return view('admin.prices.create', compact('prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear precio')) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'value' => 'required|numeric',
        ]);

        $priceData = [
            'value' => $validatedData['value'],
        ];

        Price::create($priceData);

        return redirect()->route('admin.prices.index')->with('info', 'Precio creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        return view('admin.prices.show', compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar precio')) {
            abort(403, 'Unauthorized action.');
        }

        $prices = Price::all();
        return view('admin.prices.edit', compact('price', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar precio')) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'value' => 'required|numeric',
        ]);

        $price->update([
            'value' => $validatedData['value'],
        ]);

        return redirect()->route('admin.prices.index')->with('info', 'El precio se actualizó satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Eliminar precio')) {
            abort(403, 'Unauthorized action.');
        }

        $price->delete();
        return redirect()->route('admin.prices.index')->with('info', 'El precio se eliminó satisfactoriamente');
    }
}

