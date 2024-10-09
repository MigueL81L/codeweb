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

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|exists:roles,id', // Cambiar 'roles' por 'role'
        'password' => 'nullable|string|min:8',
    ]);

    // Actualiza los campos del usuario excepto la contraseña
    $user->update([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
    ]);

    $role = Role::findOrFail($request->role)->name; // Obtiene el nombre del rol seleccionado
    $user->syncRoles([$role]); // Asigna el rol al usuario

    // Si se proporciona una nueva contraseña, encriptarla y actualizarla
    if ($request->filled('password')) {
        $password = $request->input('password');
        $user->update(['password' => bcrypt($password)]);
        
        // Envía correo electrónico al usuario si es necesario
            Mail::send('emails.password_changed', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Su contraseña ha sido cambiada');
            });
        }

        return redirect()->route('admin.users.index')->with('info', 'Usuario actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(User $user)
    // {
    //     // Verifica si el usuario autenticado tiene el permiso de 'Eliminar usuarios'
    //     if (Gate::denies('Eliminar usuarios')) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     // Elimina el usuario
    //     $user->delete();

    //     return redirect()->route('admin.users.index')->with('info', 'Usuario eliminado con éxito');
    // }


    public function destroy(User $user)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Eliminar usuarios'
        if (Gate::denies('Eliminar usuarios')) {
            abort(403, 'Unauthorized action.');
        }
    
        // Verifico que el usuario sea un Instructor, sino no habrá creado cursos
        if ($user->hasRole('Instructor')) {

            // Obtengo la lista completa de courses existentes
            $courses = Course::all();
    
            // Itero la lista de cursos, si el id del teacher de un determinado course, 
            // coincide con el id user que pretendo eliminar, elimino dicho curso
            foreach ($courses as $course) {
                if($course->teacher->id==$user->id){
                    $course->delete();
                }
            }
        }
    
        // Finalmente, elimina el usuario
        $user->delete();
    
        return redirect()->route('admin.users.index')->with('info', 'Usuario eliminado con éxito');
    }
    

} 


