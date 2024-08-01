<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;

use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\Validate;
use phpDocumentor\Reflection\Types\True_;




class PromotionalVideo extends Component
{
    use WithFileUploads; //Me permite subir imagenes, videos, ...etc

    //Defino variables
    public $course;

    //Valido que sea cualquier tipo de video
    #[Validate('required', 'mimeTypes:video/*')]
    public $video;

    //Método que guardará el vídeo promocional
    public function save()
    {
        $this->validate();
        $this->course->video_path = $this->video->store('courses/promotional-videos');
        $this->course->save();

        
        //Redirección con barra de carga
        return $this->redirectRoute('instructor.courses.video', $this->course, true, true);
    }

    public function render()
    {
        return view('livewire.instructor.courses.promotional-video');
    }
}
