<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Estudiante
        $roleStudent = Role::create(['name' => 'Estudiante']);
        $roleStudent->syncPermissions([
            'Leer cursos'
        ]);

        // Instructor
        $roleInstructor = Role::create(['name' => 'Instructor']);
        $roleInstructor->syncPermissions([
            'Crear cursos',
            'Leer cursos',
            'Actualizar cursos',
            'Eliminar cursos'
        ]);
        
        // Administrador
        $roleAdmin = Role::create(['name' => 'Administrador']);
        $roleAdmin->syncPermissions([
            'Leer cursos',
            'Ver dashboard',
            
            // Permisos referentes a roles
            'Crear role',
            'Editar role',
            'Listar role',
            'Eliminar role',
            
            // Permisos referentes a usuarios
            'Leer usuarios',
            'Editar usuarios',
            'Crear usuarios',
            'Eliminar usuarios',
            
            // Permisos referentes a categorías
            'Crear categoria',
            'Editar categoria',
            'Listar categorias',
            'Eliminar categoria',
            
            // Permisos referentes a niveles
            'Crear nivel',
            'Editar nivel',
            'Listar niveles',
            'Eliminar nivel',
            
            // Permisos referentes a precios
            'Crear precio',
            'Editar precio',
            'Listar precios',
            'Eliminar precio',
        ]);


    }
}
