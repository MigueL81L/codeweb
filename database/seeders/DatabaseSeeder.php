<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Mediante el método call, genero datos de prueba en category, level y price
        //Me genera tantos registros como casos distintos, haya en cada array preestablecido
        $this->call([
            CategorySeeder::class,
            LevelSeeder::class,
            PriceSeeder::class,
            //Primero hay que crear los permisos y luego los roles, puesto que estos llevan a los otros
            PermissionSeeder::class,
            RoleSeeder::class,
            //Los users tienen roles y permisos, osea que no es hasta aqui que los creo
            UserSeeder::class,
        ]);
    }
}
