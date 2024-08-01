<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    //Cuando se crea un controlador que controla una única ruta, se usa __invoke()
    //En la página home debo listar los cursos existentes
    public function __invoke()
    {
        //Solo muestro los cursos culminados, no borradores, por ejemplo, estos son aquellos cuyo status=3
        //Y los muestro añadiendo el número de estudiantes que los cursan, ordenados por su fecha de creación, 
        //y dentro de esto, por su id. Como mucho, muestro los últimos 12, aunque haya 300
        $courses=Course::where('status', '3')->withCount(['students'])->latest('id')->get()->take(12);

        return view('welcome', compact('courses'));
    }
}
