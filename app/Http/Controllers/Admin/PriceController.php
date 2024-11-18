<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'value' => 'required|numeric|unique:prices,value',
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
            'value' => 'required|numeric|unique:prices,value,' . $price->id,
        ]);

        $price->update([
            'value' => $validatedData['value'],
        ]);

        return redirect()->route('admin.prices.index')->with('info', 'El precio se actualizó satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Price $price)
    // {

    //     // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
    //     if (Gate::denies('Eliminar precio')) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $price->delete();
    //     return redirect()->route('admin.prices.index')->with('info', 'El precio se eliminó satisfactoriamente');
    // }

    public function destroy(Price $price)
{
    // Verifica si el usuario autenticado tiene el permiso de 'Eliminar precio'
    if (Gate::denies('Eliminar precio')) {
        abort(403, 'Unauthorized action.');
    }

    try {
        // Iterar y eliminar cada curso asociado al precio
        $price->courses->each(function ($course) {
            // Eliminar imagen del curso si existe
            if ($course->courseImage && Storage::exists($course->courseImage->path)) {
                Storage::delete($course->courseImage->path);
                $course->courseImage->delete();
            }

            // Eliminar reviews, goals y requirements
            $course->reviews()->delete();
            $course->goals()->delete();
            $course->requirements()->delete();

            // Eliminar sections y sus lecciones
            $course->sections->each(function ($section) {
                $section->lessons->each(function ($lesson) {
                    // Eliminar videos y documentos de las lecciones
                    if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                        Storage::delete($lesson->video_path);
                    }

                    if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                        Storage::delete($lesson->document_path);
                    }

                    $lesson->delete();
                });

                $section->delete();
            });

            // Eliminar video del curso si existe
            if ($course->video_path && Storage::exists($course->video_path)) {
                Storage::delete($course->video_path);
            }

            // Finalmente, eliminar el curso
            $course->delete();
        });

        // Ahora eliminar el precio
        $price->delete();

        return redirect()->route('admin.prices.index')->with('info', 'El precio y sus cursos asociados fueron eliminados satisfactoriamente!');
    } catch (\Exception $e) {
        // Registro y manejo de errores
        Log::error('Error al eliminar el precio y sus cursos: ' . $e->getMessage());
        return back()->withErrors(['msg' => 'Error al eliminar el precio y cursos: ' . $e->getMessage()]);
    }
}
}

