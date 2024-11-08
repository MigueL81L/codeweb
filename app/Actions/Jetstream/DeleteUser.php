<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    // public function delete(User $user): void 
    // {
    //     $user->deleteProfilePhoto();
    //     $user->tokens->each->delete();
    //     $user->delete();
    // }

    /**
     * Delete the given user.
     */
    public function delete(User $user): void 
    {
        // Elimina todos los cursos y sus relaciones del usuario
        $courses = Course::where('user_id', $user->id)->get();
        
        foreach ($courses as $course) {
            // Elimina todos los recursos del curso antes de eliminar el curso
            
            // Eliminar reseñas del curso
            $course->reviews()->delete();
            // Eliminar metas del curso
            $course->goals()->delete();
            // Eliminar requisitos del curso
            $course->requirements()->delete();

            // Eliminar lecciones y sus recursos
            $course->lessons->each(function($lesson) {
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                if ($lesson->image_path && Storage::exists($lesson->image_path)) {
                    Storage::delete($lesson->image_path);
                }
                if ($lesson->document_path && Storage::exists($lesson->document_path)) { 
                    Storage::delete($lesson->document_path);
                }
                $lesson->delete(); // Eliminar lección
            });

            // Eliminar secciones del curso
            $course->sections()->delete();

            if ($course->courseImage) {
                if (Storage::exists($course->courseImage->path)) {
                    Storage::delete($course->courseImage->path);
                }
                $course->courseImage->delete();
            }

            if ($course->video_path && Storage::exists($course->video_path)) {
                Storage::delete($course->video_path);
            }

            // Finalmente, eliminar el curso
            $course->delete();
        }

        // Eliminar la foto de perfil del usuario si existe
        $user->deleteProfilePhoto();

        // Eliminar tokens asociados
        $user->tokens->each->delete();

        // Finalmente, eliminar el usuario
        $user->delete();
    }
}
