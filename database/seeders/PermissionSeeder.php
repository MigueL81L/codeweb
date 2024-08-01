<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Permisos de Cursos

        //Permiso universal, para estudiante, instructor o administrador loggueado y presente en la bbdd
        Permission::create([
            'name' => 'Leer cursos',
            
        ]);




        //Permisos solo para el Instructor
        Permission::create([
            'name' => 'Crear cursos',

        ]);

        Permission::create([
            'name' => 'Actualizar cursos',
            
        ]);


        Permission::create([
            'name' => 'Eliminar cursos',
            
        ]);




        //Permisos solo para el administrador

        //Permiso de visualización de la pantalla dashboard
        Permission::create([
            'name' => 'Ver dashboard',
            
        ]);



        //Permisos referentes a los roles
        Permission::create([
            'name' => 'Crear role',
            
        ]);

        Permission::create([
            'name' => 'Editar role',
            
        ]);


        Permission::create([
            'name' => 'Listar role',
            
        ]);


        Permission::create([
            'name' => 'Eliminar role',
            
        ]);



        //Permisos referidos a los users
        Permission::create([
            'name' => 'Leer usuarios',
            
        ]);

        Permission::create([
            'name' => 'Editar usuarios',
            
        ]);

        Permission::create([
            'name' => 'Crear usuarios',
            
        ]);

        Permission::create([
            'name' => 'Eliminar usuarios',
            
        ]);



        //Permisos referentes a las Categorías
        Permission::create([
            'name' => 'Crear categoria',
                    
        ]);
        
        Permission::create([
            'name' => 'Editar categoria',
                    
        ]);
        
        
        Permission::create([
            'name' => 'Listar categorias',
                    
        ]);
        
        
        Permission::create([
            'name' => 'Eliminar categoria',
                    
        ]);



        //Permisos referentes a los Niveles
        Permission::create([
            'name' => 'Crear nivel',
                            
        ]);
                
        Permission::create([
            'name' => 'Editar nivel',
                            
        ]);
                
                
        Permission::create([
            'name' => 'Listar niveles',
                            
        ]);
                
                
        Permission::create([
            'name' => 'Eliminar nivel',
                            
        ]);
        



        //Permisos referentes a los Precios
        Permission::create([
            'name' => 'Crear precio',
                        
        ]);
            
        Permission::create([
            'name' => 'Editar precio',
                        
        ]);
            
            
        Permission::create([
            'name' => 'Listar precios',
                        
        ]);
            
            
        Permission::create([
            'name' => 'Eliminar precio',
                        
        ]);

    }
}
