<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
            'name' => 'required|string|max:25|unique:levels,name',
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
            'name' => 'required|string|max:25|unique:levels,name,' . $level->id,
        ]);
    
        $level->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('admin.levels.index')->with('info', 'El nivel se actualizó satisfactoriamente!');
    }


        public function destroy(Level $level)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Eliminar nivel'
        if (Gate::denies('Eliminar nivel')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Iterar y eliminar cada curso asociado al nivel
            $level->courses->each(function ($course) {
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

            // Ahora eliminar el nivel
            $level->delete();

            return redirect()->route('admin.levels.index')->with('info', 'El nivel y sus cursos asociados fueron eliminados satisfactoriamente!');
        } catch (\Exception $e) {
            // Registro y manejo de errores
            Log::error('Error al eliminar el nivel y sus cursos: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Error al eliminar el nivel y cursos: ' . $e->getMessage()]);
        }
    }
}
