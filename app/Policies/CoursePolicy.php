<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //Siempre que se genere un método en un policie hay que pasarle el objeto User user

    //Método que busca comprobar si un alumno, está o no está matriculado
    //A un método policie hay que pasarle siempre el usuario autentificado, 
    //y puede pasársele tb otro parámetro como un curso.
    //Este método debe devolver un booleano
     //No matriculado ->false, Si matriculado->true
    public function enrolled(User $user, Course $course){
        //De todos los alumnos matriculados a este curso, alguno contiene el id del alumno autentificado?
        if($course->students->contains($user->id)){
            return true;
        }else{
            return false;
        }
    }

   
}
