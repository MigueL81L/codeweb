<?php

namespace App\Observers;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LessonObserver
{
    public function creating(Lesson $lesson){
        //La posición, será la mayor, de las posiciones, de las lecciones, que corresponden 
        //a la colección de lecciones, que pertenecen a una determinada section, y a dicha
        //posición se le suma 1
        $lesson->position = Lesson::where('section_id', $lesson->section_id)->max('position')+1;

        //También genero el slug dinamicamente, basicamente convirtiendo el name de la lesson
        //en una cadena, separada por guiones
        $lesson->slug=Str::slug($lesson->name);
        
    }


    public function deleting(Lesson $lesson)
    {
        // Eliminar el video asociado a la lección si existe
        if ($lesson->video_path) {
            Storage::delete($lesson->video_path);
        }

        // Eliminar la imagen de portada asociada a la lección si existe
        if ($lesson->image_path) {
            Storage::delete($lesson->image_path);
        }
    }
}
