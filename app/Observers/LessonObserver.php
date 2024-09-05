<?php

namespace App\Observers;

use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LessonObserver
{
    public function creating(Lesson $lesson)
    {
        // Asigna la posición automáticamente
        $lesson->position = Lesson::where('section_id', $lesson->section_id)->max('position') + 1;

        // Genera el slug dinámicamente
        $lesson->slug = Str::slug($lesson->name);
    }

    public function updating(Lesson $lesson)
    {
        // Actualiza el slug si el nombre de la lección cambia
        if ($lesson->isDirty('name')) {
            $lesson->slug = Str::slug($lesson->name);
        }
    
        // Maneja la eliminación de archivos si se actualizan
        if ($lesson->isDirty('video_path')) {
            $originalPath = $lesson->getOriginal('video_path');
            if ($originalPath && Storage::exists($originalPath)) {
                Storage::delete($originalPath);
            }
        }
    
        if ($lesson->isDirty('document_path')) {
            $originalPath = $lesson->getOriginal('document_path');
            if ($originalPath && Storage::exists($originalPath)) {
                Storage::delete($originalPath);
            }
        }
    }
    

    public function deleting(Lesson $lesson)
    {
        // Elimina el video asociado a la lección si existe
        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        // Elimina el documento asociado a la lección si existe
        if ($lesson->document_path && Storage::exists($lesson->document_path)) {
            Storage::delete($lesson->document_path);
        }

        // Elimina la imagen de portada asociada a la lección si existe
        if ($lesson->image_path && Storage::exists($lesson->image_path)) {
            Storage::delete($lesson->image_path);
        }
    }
}

