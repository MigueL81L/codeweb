<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\Category; // Aquí se corrige el espacio de nombres del modelo Category

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories=[
            'Desarrollo Web',
            'Desarrollo Móvil',
            'Desarrollo Videojuegos',
            'Bases de datos',
            'Ofimática',
            'Ciberseguridad',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'=>$category,
            ]);
        }
    }
}

