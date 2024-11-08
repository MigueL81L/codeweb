<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Leer usuarios'
        if (Gate::denies('Leer usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.users.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
        if (Gate::denies('Crear usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));  
    }

 

    public function store(Request $request)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
        if (Gate::denies('Crear usuarios')) {
            abort(403, 'Unauthorized action.');
        }
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|exists:roles,id', // Cambiar 'roles' por 'role'
            'password' => 'required|string|min:8',
        ]);
    
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ];
    
        $user = User::create($userData);
    
        $role = Role::findOrFail($request->role)->name; // Obtiene el nombre del rol seleccionado
        $user->syncRoles([$role]); // Asigna el rol al usuario
    
        return redirect()->route('admin.users.index')->with('info', 'Usuario creado con éxito');
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
        if (Gate::denies('Editar usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        // Colección de todos los roles existentes
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
        if (Gate::denies('Editar usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        // Obtener el usuario autenticado
        // $authUser = auth()->user();
        $authUser = Auth::user();

        // Comprobar si el usuario que se intenta editar es el mismo que está autenticado
        if ($user->id === $authUser->id) {
        return redirect()->route('admin.users.index')->with('warning', 'No puedes editar tu propia cuenta. Por favor, utiliza el menú de tu perfil para realizar cambios.');
        }

        // Comprobar si el usuario que se pretende editar es un administrador
        if ($user->hasRole('Administrador')) {
        return redirect()->route('admin.users.index')->with('warning', 'No puedes editar a otro administrador. Este debe gestionar su cuenta desde su propio perfil.');
        }

        //No debo permitir que un adeministrador pueda modificar la password o el email de un usuario, puesto que si pudiera, podría hacerse con la cuenta del usuario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,id', 
        ]);

        // Actualiza los campos del usuario excepto la contraseña
        $user->update($validatedData);

        $role = Role::findOrFail($request->role)->name; // Obtiene el nombre del rol seleccionado
        $user->syncRoles([$role]); // Asigna el rol al usuario

        return redirect()->route('admin.users.index')->with('info', 'Usuario actualizado con éxito');
    }

    public function destroy(User $user)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Eliminar usuarios'
        if (Gate::denies('Eliminar usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        // Obtener el usuario autenticado
        // $authUser = auth()->user();
        $authUser = Auth::user();

        // Comprobar si el usuario que se intenta eliminar es el mismo que está autenticado
        if ($user->id === $authUser->id) {
            return redirect()->route('admin.users.index')->with('warning', 'No puedes eliminar tu propia cuenta. Por favor, utiliza el menú de tu perfil para darte de baja.');
        }

        // Comprobar si el usuario que se pretende eliminar es un administrador
        if ($user->hasRole('Administrador')) {
        return redirect()->route('admin.users.index')->with('warning', 'No puedes eliminar a otro administrador. Este debe darse de baja por si mismo');
        }

        // Verifica y elimina la foto de perfil del usuario si existe
        if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
            Storage::delete($user->profile_photo_path);
            Log::info("Foto de perfil del usuario de id: {$user->id} eliminada.");
        }

        // Borra el valor de profile_photo_path de la base de datos
        $user->update(['profile_photo_path' => null]);
    
        // Verifico que el usuario sea un Instructor
        if ($user->hasRole('Instructor')) {
            Log::info("Eliminando cursos del instructor de id: {$user->id}");
    
            // Obtener todos los courses de la bbdd
            $courses = Course::all();
    
            // Iterar sobre cada curso y en caso de que este user sea su profesor, eliminar todos los recursos relacionados
            foreach ($courses as $course) {
                Log::info("Eliminando curso de id: {$course->id}");

                if($course->teacher->id==$user->id){
                    // Eliminar los datos relacionados con el curso
                    $course->reviews()->delete();
                    $course->goals()->delete();
                    $course->requirements()->delete();
        
                    foreach ($course->lessons as $lesson) {
                        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                            Storage::delete($lesson->video_path);
                        }
                        if ($lesson->image_path && Storage::exists($lesson->image_path)) {
                            Storage::delete($lesson->image_path);
                        }
                        if ($lesson->document_path && Storage::exists($lesson->document_path)) { 
                            Storage::delete($lesson->document_path);
                            Log::info('Documento eliminado: ' . $lesson->document_path);
                        }
                        $lesson->delete();
                        Log::info("Eliminada lección de id: {$lesson->id}");
                    }
        
                    $course->sections()->delete();
                    Log::info("Secciones eliminadas para curso de id: {$course->id}");
        
                    if ($course->courseImage) {
                        if (Storage::exists($course->courseImage->path)) {
                            Storage::delete($course->courseImage->path);
                        }
                        $course->courseImage->delete();
                        Log::info("Imagen del curso de id: {$course->id} eliminada.");
                    }
        
                    if ($course->video_path && Storage::exists($course->video_path)) {
                        Storage::delete($course->video_path);
                        Log::info("Video del curso de id: {$course->id} eliminado.");
                    }
        
                    $course->delete();
                    Log::info("Curso de id: {$course->id} eliminado.");
                }
            }
        }
    
        // Finalmente, elimina el usuario después de eliminar todos sus cursos. O lo elimina directamente si el user no es instructor, o lo es, sin courses creados
        Log::info("Eliminando usuario de id: {$user->id}");
        $user->delete();
    
        return redirect()->route('admin.users.index')->with('info', 'Usuario eliminado con éxito');
    }
    


}