<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea el rol de Administrador si no existe
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);

        // Crea el rol de Estudiante si no existe
        $studentRole = Role::firstOrCreate(['name' => 'Estudiante']);

        // Crea el usuario de prueba con el rol de Administrador
        $user = User::create([
            'name' => 'Michael Night',
            'email' => 'mNight@gmail.com',
            'password' => bcrypt('12345678') // Asegúrate de que esto use bcrypt
        ]);

        // Asigna el rol de Administrador al usuario
        $user->assignRole($adminRole);

        // No creamos usuarios adicionales en este seeder, ya que se registrarán sólo a través de la aplicación.
    }
}

