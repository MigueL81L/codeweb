<?php

namespace App\Http\Controllers\Admin;  

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;


class RoleController extends Controller  
{

    /**
     * Display a listing of the resource.  
     */
    public function index()
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Listar role')) {
            abort(403, 'Unauthorized action.');
        }

        //Aqui recuperaré todos lso roles presentes en mi bbdd
        $roles = Role::all();

        //Le paso los roles a la vista
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear role')) {
            abort(403, 'Unauthorized action.');
        }

        //Recupero todos los permisos existentes, y se los paso a la vista
        $permissions=Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Crear role')) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);

        //Creo variable con el name, que me llega del formulario
        $role = Role::create([
            'name' => $request->name,
        ]);

        //Le seteo los permisos al rol que han sido marcados, accediendo a la relación que 
        //tiene con los permisos, la tabla persmissions, y la tabla intermedia entre roles y permissions
        $role->permissions()->attach($request->permissions);

        //Redireccionamiento, para mostrar los roles en la vista index, con mensaje de sesion satisfactorio
        return redirect()->route('admin.roles.index')->with('info', 'El Rol se creo satisfactoriamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar role')) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();
    
        // Obtener los permisos asignados a este rol
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
    
        return view('admin.roles.edit', compact('role', 'permissions', 'selectedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Editar role')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);
    
        $role->update([
            'name' => $request->name,
        ]);
    
        // Sincronizar los permisos del rol
        $role->permissions()->sync($request->permissions);
    
        $permissions = Permission::all();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
    
        // return view('admin.roles.update', compact('role', 'permissions', 'selectedPermissions'))->with('info', 'Rol actualizado satisfactoriamente!');
        return redirect()->route('admin.roles.index')->with('info', 'El Rol se actualizó satisfactoriamente!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Verifica si el usuario autenticado tiene el permiso de 'Listar roles'
        if (Gate::denies('Eliminar role')) {
            abort(403, 'Unauthorized action.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('info', 'El Rol se eliminó satisfactoriamente!');
    }
}
