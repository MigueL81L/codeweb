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

        foreach ($course->sections->sortBy('position') as $section) {
            foreach ($section->lessons as $lesson) {
                $this->lfs->push($lesson);
            }
        }

        $incompleteLessons = $this->lfs->filter(function ($lesson) {
            return !$lesson->completed;
        });

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
        $this->updatePrevNext();
        $this->authorize('enrolled', $course);
    }

    public function changeLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId); // Resolver el ID a un objeto Lesson

        $this->current = $lesson;
        $this->index = $this->lfs->search(function($l) use ($lesson) {
            return $l->id === $lesson->id;
        });

        $this->updatePrevNext();
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

        return $url;
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
            '3gp' => 'video/3gpp',
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
        $completedCount = $this->lfs->filter(function($lesson) {
            return $lesson->completed;
        })->count();
    
        $totalLessons = $this->lfs->count();
    
        if ($totalLessons > 0) {
            return round(($completedCount / $totalLessons) * 100, 2); 
        } else {
            return 0; 
        }
    }

    public function render()
    {
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance, 
            'currentIframe' => $this->current->platform == 2 ? $this->getYoutubeEmbedUrl($this->current->video_original_name) : null,
            'currentMimeType' => $this->current->platform == 1 ? $this->getMimeType($this->current->video_path) : null,
        ]);
    }
}





