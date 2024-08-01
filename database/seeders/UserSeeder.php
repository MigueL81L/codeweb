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
        $user = User::factory()->create([
            'name' => 'Michael Night',
            'email' => 'mNight@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        // Asigna el rol de Administrador al usuario
        $user->assignRole($adminRole);

        // Rellena la tabla con 49 usuarios más, asignándoles el rol de Estudiante
        User::factory(49)->create()->each(function ($user) use ($studentRole) {
            $user->assignRole($studentRole);
        });

        // Elimina cualquier rol existente y asigna solo el rol de Estudiante a los usuarios, excepto al usuario inicial $user
        $usersExceptAdmin = User::where('id', '!=', 1)->get(); // Excluding the initial $user (usually with ID 1)
        foreach ($usersExceptAdmin as $user) {
            $user->syncRoles([$studentRole]);
        }
    }
}

