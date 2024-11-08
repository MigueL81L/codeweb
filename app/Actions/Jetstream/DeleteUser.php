<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Models\Course;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    // public function delete(User $user): void 
    // {
    //     $user->deleteProfilePhoto();
    //     $user->tokens->each->delete();
    //     $user->delete();
    // }

    public function delete(User $user): void 
    {
        // Elimina todos los cursos y sus relaciones del usuario
        $courses = Course::where('user_id', $user->id)->get();
        foreach ($courses as $course) {
            // Aquí eliminas las lecciones, secciones y demás recursos del curso
            $course->reviews()->delete();
            $course->goals()->delete();
            $course->requirements()->delete();
            $course->sections()->each(function($section) {
                $section->lessons()->delete(); // Eliminar lecciones de la sección
                $section->delete(); // Eliminar la propia sección
            });
            $course->courseImage()->delete(); // Eliminar imagen del curso si existe
            $course->delete(); // Eliminar el curso
        }

        // Eliminar la foto de perfil del usuario si existe
        $user->deleteProfilePhoto();

        // Eliminar tokens asociados
        $user->tokens->each->delete();

        // Finalmente, eliminar el usuario
        $user->delete();
    }
}
