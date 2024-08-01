<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use Illuminate\Support\Facades\Gate;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Listar niveles')) {
            abort(403, 'Unauthorized action.');
        }

        $levels=Level::all();
        return view('admin.levels.index',compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear nivel')) {
            abort(403, 'Unauthorized action.');
        }

        $levels=Level::all();
        return view('admin.levels.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear nivel')) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
        ]);
    
        $levelData = [
            'name' => $validatedData['name'],
        ];
    
        $level = Level::create($levelData);
    
        return redirect()->route('admin.levels.index')->with('info', 'Nivel creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        return view('admin.levels.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar nivel')) {
            abort(403, 'Unauthorized action.');
        }

        $levels=Level::all();
        return view('admin.levels.edit', compact('level', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar nivel')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
        ]);
    
        $level->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('admin.levels.index')->with('info', 'El nivel se actualizó satisfactoriamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Eliminar nivel')) {
            abort(403, 'Unauthorized action.');
        }

        $level->delete();
        return redirect()->route('admin.levels.index')->with('info', 'El nivel se eliminó satisfactoriamente!');
    }
}
