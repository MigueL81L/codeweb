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
    public $course, $current, $lfs, $index;

    public $previous, $next;



    public function mount(Course $course)
    {
        
        try {
            //Inicializo public $course
            $this->course = $course;

            //Inicializo public $index
            $this->index = 0;

            //Inicializo public $lfs
            $this->lfs = collect();

            //Relleno la colección lfs con las lessons del course
            foreach ($course->sections->sortBy('position') as $section) {
                foreach ($section->lessons as $lesson) {
                    $this->lfs->push($lesson);
                }
            }


            //Colección $incompleteLessons que agrupa las lessons que no han sido completadas
            $incompleteLessons = $this->lfs->filter(function ($lesson) {
                return !$lesson->completed;
            });

            //Definición de public $current, en función de la lista de lessons incompletas
            if ($incompleteLessons->isEmpty()) {
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

            // Inicializo public $previous y $next
            $this->previous = null; // Inicialización a null
            $this->next = null; // Inicialización a null


            $this->updatePrevNext();
            $this->authorize('enrolled', $course);
        } catch (\Exception $e) {
            Log::error('mount: Error occurred - ' . $e->getMessage());
        }
    }

    public function changeLesson($lessonId)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);

            //Modificación de public $current y public $index
            $this->current = $lesson;
            $this->index = $this->lfs->search(function ($l) use ($lesson) {
                return $l->id === $lesson->id;
            });

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
    }

    

    public function completed()
    {
        if ($this->current->completed) {
            $this->current->users()->detach(auth()->user()->id);
        } else {
            $this->current->users()->attach(auth()->user()->id);
        }

        $this->current = Lesson::find($this->current->id);
        $this->course = Course::find($this->course->id);
    }

    //Méto para establecer la barra de progreso en el course
    public function getAdvanceProperty()
    {
        $completedCount = $this->lfs->filter(function ($lesson) {
            return $lesson->completed;
        })->count();

        $totalLessons = $this->lfs->count();
        $advance = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 2) : 0;

        return $advance;
    }

    public function render()
    {
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance,
        ]);
    }
    
    
}















