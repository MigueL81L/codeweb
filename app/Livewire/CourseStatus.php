<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseStatus extends Component  
{
    use AuthorizesRequests;

    public $course, $current;
    public $index, $previous, $next;
    public $lfs;
    public $iframeLoaded = false; // Nueva propiedad para controlar la carga del iframe

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->index = 0;
        $this->lfs = collect();

        foreach ($course->sections->sortBy('position') as $section) {
            foreach ($section->lessons as $lesson) {
                $this->lfs->push($lesson);
            }
        }

        $incompleteLessons = $this->lfs->filter(function ($lesson) {
            return !$lesson->completed;
        });

        $this->current = $incompleteLessons->isEmpty() ? $this->lfs->last() : $incompleteLessons->first();
        $this->updatePrevNext();
        $this->authorize('enrolled', $course);
    }

    public function changeLesson($lessonId)
    {
        $this->current = Lesson::findOrFail($lessonId);
        $this->index = $this->lfs->search(fn($l) => $l->id === $this->current->id);

        $this->updatePrevNext();
        $this->iframeLoaded = false; // Reinicia la propiedad al cambiar de lección
    }

    private function updatePrevNext()
    {
        $this->previous = $this->index > 0 ? $this->lfs[$this->index - 1] : null;
        $this->next = $this->index < $this->lfs->count() - 1 ? $this->lfs[$this->index + 1] : null;
    }

    private function getYoutubeEmbedUrl($url)
    {
        preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
        $videoId = $matches[3] ?? null;
    
        if ($videoId) {
            return "https://www.youtube.com/embed/" . $videoId;
        }

        return null;
    }

    private function getMimeType($path)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mimeTypes = [
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'flv' => 'video/x-flv',
            '3gp' => 'video/3gpp'
        ];

        return $mimeTypes[$ext] ?? 'application/octet-stream';
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

    public function getAdvanceProperty()
    {
        $completedCount = $this->lfs->filter(fn($lesson) => $lesson->completed)->count();
        $totalLessons = $this->lfs->count();

        return $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 2) : 0; 
    }

    public function render()
    {
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance, 
            'currentIframe' => $this->current->platform == 2 ? $this->getYoutubeEmbedUrl($this->current->video_original_name) : null,
            'currentMimeType' => $this->current->platform == 1 ? $this->getMimeType($this->current->video_path) : null,
            'iframeLoaded' => $this->iframeLoaded, // Pasar la propiedad al render
        ]);
    }
}












