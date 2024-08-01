<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseStatus extends Component  
{
    use AuthorizesRequests;

    public $course, $current;
    public $index, $previous, $next;
    public $lfs;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->index = 0;
        $this->lfs = collect();

        //Recorro cada section del course, y cada lesson de cada section ordenadas por 'position'
        foreach ($course->sections->sortBy('position') as $section) {
            foreach ($section->lessons as $lesson) {
                //Meto las lessons asi ordenadas en una colección
                $this->lfs->push($lesson);
            }
        }

        //Determino las lessons que están incompletas
        $incompleteLessons = $this->lfs->filter(function ($lesson) {
            return !$lesson->completed;
        });

        if ($incompleteLessons->isEmpty()) {
            // Si todas las lecciones están completadas, mostrar la última lección
            $this->current = $this->lfs->last();
        } else {
            foreach ($this->lfs as $lesson) {
                if (!$lesson->completed) {
                    $this->current = $lesson;
                    break;
                }
                $this->index++;
            }
        }

        $this->updatePrevNext();

        //Protección de rutas, aplicando la policie CoursePolicy.php
        $this->authorize('enrolled', $course);
    }

    public function changeLesson(Lesson $lesson)
    {
        //Método para que la aplicación cambie de lesson, conforme sea clickada por el usuario
        $this->current = $lesson;
        $this->index = $this->lfs->search(function($l) use ($lesson) {
            return $l->id === $lesson->id;
        });

        $this->updatePrevNext(); // Actualizar previous y next
    }

    private function updatePrevNext()
    {
        //Determinación de las lecciones anterior y posterior

        // Establecer la lección anterior si el índice es mayor que 0
        $this->previous = $this->index > 0 ? $this->lfs[$this->index - 1] : null;

        // Establecer la lección siguiente si el índice es menor que el tamaño de la colección menos 1
        $this->next = $this->index < $this->lfs->count() - 1 ? $this->lfs[$this->index + 1] : null;
    }

    public function completed(){
        //Método para marcar la lección como completada en el correspondiente botón/barra progreso

        if($this->current->completed){
            //Si la lesson está completada y pulso el botón, ya no estará completada, 
            //y la elimino de la tabla lesson_user. Liquido la del user autentificado, que es el que está operando
            $this->current->users()->detach(auth()->user()->id);
        }else{
            //En caso contrario al anterior, la lesson pasa a considerarse completada y la agrego a la tabla
            $this->current->users()->attach(auth()->user()->id);
        }

        //Actualización
        $this->current = Lesson::find($this->current->id);  
        $this->course = Course::find($this->course->id);
        
    }

    public function getAdvanceProperty()
    {
        $completedCount = $this->lfs->filter(function($lesson) {
            return $lesson->completed;
        })->count();
    
        $totalLessons = $this->lfs->count();
    
        if ($totalLessons > 0) {
            return round(($completedCount / $totalLessons) * 100, 2); // Calcula el porcentaje redondeado a 2 decimales
        } else {
            return 0; // Si no hay lecciones, el avance es 0%
        }
    }

    private function getYoutubeEmbedUrl($url)
    {
        // Regular expression to extract YouTube video ID
        preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
        $videoId = $matches[3] ?? null;

        if ($videoId) {
            return "https://www.youtube.com/embed/" . $videoId;
        }

        return $url;
    }
    public function render()
    {
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance, // Pasando la propiedad computada
            'currentIframe' => $this->current->platform == 2 ? $this->getYoutubeEmbedUrl($this->current->video_original_name) : null,
        ]);
    }
}