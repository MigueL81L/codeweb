<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
    // public function destroy(Category $category)
    // {

    //     // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
    //     if (Gate::denies('Eliminar categoria')) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $category->delete();
    //     return redirect()->route('admin.categories.index')->with('info', 'La Categoría se eliminó satisfactoriamente!');
    // }

    public function destroy(Category $category)
    {
        if (Gate::denies('Eliminar categoria')) {
            abort(403, 'Unauthorized action.');
        }
    
        try {
            // Iterar y eliminar cada curso asociado a la categoría
            $category->courses->each(function ($course) {
                // Eliminar imagen del curso si existe
                if ($course->courseImage && Storage::exists($course->courseImage->path)) {
                    Storage::delete($course->courseImage->path);
                    $course->courseImage->delete();
                }
    
                // Eliminar reviews, goals y requirements
                $course->reviews()->delete();
                $course->goals()->delete();
                $course->requirements()->delete();
    
                // Eliminar sections y their lessons
                $course->sections->each(function ($section) {
                    $section->lessons->each(function ($lesson) {
                        // Eliminar videos y documentos de lecciones
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
    
            // Ahora eliminar la categoría
            $category->delete();
    
            return redirect()->route('admin.categories.index')->with('info', 'La Categoría y sus cursos asociados fueron eliminados satisfactoriamente!');
        } catch (\Exception $e) {
            // Registro y manejo de errores
            Log::error('Error al eliminar la categoría y sus cursos: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Error al eliminar la categoría y cursos: ' . $e->getMessage()]);
        }
    }
}
