<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class CourseStatus extends Component
{
    use AuthorizesRequests;

    //Definidas en el método mount()
    public $course, $current, $lfs, $index, $currentIframe;

    public $previous, $next;



    public function mount(Course $course)
    {
        Log::info('mount: Method called');
        
        try {
            //Inicializo public $course
            $this->course = $course;
            Log::info('mount: Course set with ID: ' . $course->id);

            //Inicializo public $index
            $this->index = 0;

            //Inicializo public $lfs
            $this->lfs = collect();
            Log::info('mount: Initialized lesson collection');

            //Relleno la colección lfs con las lessons del course
            foreach ($course->sections->sortBy('position') as $section) {
                Log::info('mount: Processing section ID: ' . $section->id);
                foreach ($section->lessons as $lesson) {
                    $this->lfs->push($lesson);
                    Log::info('mount: Added lesson ID: ' . $lesson->id);
                }
            }

            Log::info('mount: Total lessons collected: ' . $this->lfs->count());

            //Colección $incompleteLessons que agrupa las lessons que no han sido completadas
            $incompleteLessons = $this->lfs->filter(function ($lesson) {
                return !$lesson->completed;
            });

            //Definición de public $current, en función de la lista de lessons incompletas
            if ($incompleteLessons->isEmpty()) {
                Log::info('mount: All lessons are completed.');
                $this->current = $this->lfs->last();
            } else {
                Log::info('mount: There are incomplete lessons.');
                foreach ($this->lfs as $lesson) {
                    if (!$lesson->completed) {
                        $this->current = $lesson;
                        Log::info('mount: Setting current lesson ID: ' . $lesson->id);
                        break;
                    }
                    $this->index++;
                }
            }

            //Inicializo la variable public currentMimeType y currentIframe
            if ($this->current) {
                $this->setCurrentMimeType(); // Llama a esta función para inicializar el tipo MIME
            } else {
                // Maneja la condición si no se carga correctamente
                // $this->currentMimeType = null; // Asigna un valor por defecto si no hay lección actual
                $this->currentIframe=null;
            }

            // Inicializo public $previous y $next
            $this->previous = null; // Inicialización a null
            $this->next = null; // Inicialización a null


            $this->updatePrevNext();
            $this->authorize('enrolled', $course);
            Log::info('mount: Authorization checked');
        } catch (\Exception $e) {
            Log::error('mount: Error occurred - ' . $e->getMessage());
        }
    }

    public function changeLesson($lessonId)
    {
        Log::info('changeLesson: Changing to lesson ID: ' . $lessonId);
        try {
            $lesson = Lesson::findOrFail($lessonId);

            //Modificación de public $current y public $index
            $this->current = $lesson;
            $this->index = $this->lfs->search(function ($l) use ($lesson) {
                return $l->id === $lesson->id;
            });

            Log::info('changeLesson: Current lesson set, index: ' . $this->index);
            $this->updatePrevNext();
        } catch (\Exception $e) {
            Log::error('changeLesson: Error occurred - ' . $e->getMessage());
        }
    }

    public function updatePrevNext()
    {
        Log::info('updatePrevNext: Updating previous and next lessons');

        //Inicialización de public $previous y $next
        $this->previous = $this->index > 0 ? $this->lfs[$this->index - 1] : null;
        $this->next = $this->index < $this->lfs->count() - 1 ? $this->lfs[$this->index + 1] : null;

        Log::info('updatePrevNext: Previous lesson set to: ' . ($this->previous->id ?? 'null'));
        Log::info('updatePrevNext: Next lesson set to: ' . ($this->next->id ?? 'null'));
    }

    // public function getYoutubeEmbedUrl($url)
    // {
    //     Log::info('getYoutubeEmbedUrl: Resolving URL: ' . $url);
    //     preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
    //     $videoId = $matches[3] ?? null;

    //     if ($videoId) {
    //         Log::info('getYoutubeEmbedUrl: Video ID resolved: ' . $videoId);
    //         return "https://www.youtube.com/embed/" . $videoId;
    //     }

    //     Log::info('getYoutubeEmbedUrl: No valid video ID found.');
    //     return $url;
    // }


    public function setCurrentMimeType() {
        // Asegúrate que current esté configurado
        if ($this->current) {
            if ($this->current->platform == 1) {
                // Para videos HTML5, se puede usar getVideoType(name)
                // $this->currentMimeType = $this->current->getVideoType($this->current->video_original_name);
                $this->currentIframe = null; // No hay iframe para plataforma 1
            } elseif ($this->current->platform == 2) {
                // Para videos de YouTube, se puede usar el iframe directamente
                $this->currentIframe = $this->current->getIframeAttribute(); // Asignamos el iframe de YouTube
                // $this->currentMimeType = null;
            } else {
                // $this->currentMimeType = null; 
                $this->currentIframe = null; // Asignamos un valor nulo si no hay lección actual
            }
        } else {
            // $this->currentMimeType = null; 
            $this->currentIframe = null; 
        }
    }
    

    public function completed()
    {
        Log::info('completed: Toggling completion status for current lesson ID: ' . $this->current->id);
        if ($this->current->completed) {
            $this->current->users()->detach(auth()->user()->id);
            Log::info('completed: Lesson marked as not complete');
        } else {
            $this->current->users()->attach(auth()->user()->id);
            Log::info('completed: Lesson marked as complete');
        }

        $this->current = Lesson::find($this->current->id);
        $this->course = Course::find($this->course->id);
    }

    //Méto para establecer la barra de progreso en el course
    public function getAdvanceProperty()
    {
        Log::info('getAdvanceProperty: Calculating advance');
        $completedCount = $this->lfs->filter(function ($lesson) {
            return $lesson->completed;
        })->count();

        $totalLessons = $this->lfs->count();
        $advance = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 2) : 0;

        Log::info('getAdvanceProperty: Advance calculated: ' . $advance . '%');
        return $advance;
    }

    public function render()
    {
        Log::info('CourseStatus render method started');

        // Log::info('Rendering view with currentMimeType=' . ($this->currentMimeType ?? 'null'));

        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance,
            // 'currentMimeType'=>$this->currentMimeType,
            'currentIframe' => $this->currentIframe,
        ]);
    }
    
    
}















