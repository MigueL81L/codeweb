<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar categorias'
        if (Gate::denies('Listar categorias')) {
            abort(403, 'Unauthorized action.');
        }

        $categories=Category::all();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear categoria')) {
            abort(403, 'Unauthorized action.');
        }

        $categories=Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear categoria')) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
        ]);
    
        $categoryData = [
            'name' => $validatedData['name'],
        ];
    
        $category = Category::create($categoryData);
    
        return redirect()->route('admin.categories.index')->with('info', 'Categoría creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar categoria')) {
            abort(403, 'Unauthorized action.');
        }

        $categories=Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar categoria')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
        ]);
    
        $category->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('admin.categories.index')->with('info', 'La Categoría se actualizó satisfactoriamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Eliminar categoria')) {
            abort(403, 'Unauthorized action.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('info', 'La Categoría se eliminó satisfactoriamente!');
    }
}
