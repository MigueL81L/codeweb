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

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->lfs = $course->sections->flatMap->lessons->sortBy('position');
        $this->index = 0;

        $incompleteLessons = $this->lfs->filter(fn($lesson) => !$lesson->completed);

        $this->current = $incompleteLessons->isEmpty() ? $this->lfs->last() : $incompleteLessons->first();

        $this->updatePrevNext();
        $this->authorize('enrolled', $course);
    }

    public function changeLesson($lessonId)
    {
        $this->current = Lesson::findOrFail($lessonId);
        $this->index = $this->lfs->search(fn($lesson) => $lesson->id === $this->current->id);

        $this->updatePrevNext();
    }

    private function updatePrevNext()
    {
        $this->previous = $this->index > 0 ? $this->lfs[$this->index - 1] : null;
        $this->next = $this->index < ($this->lfs->count() - 1) ? $this->lfs[$this->index + 1] : null;
    }

    private function getYoutubeEmbedUrl($url)
    {
        preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
        $videoId = $matches[3] ?? null;
    
        if ($videoId) {
            return "https://www.youtube.com/embed/" . $videoId;
        }
    
        return null; // devuelves null si no es un video de youtube
    }

    private function getMimeType($path)
    {
        // Asumiendo que no hay problemas en determinar el tipo MIME
        // Retorna un MIME especificado para cada tipo de extensión
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

    public function render()
    {
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'currentIframe' => $this->current && $this->current->platform == 2 ? $this->getYoutubeEmbedUrl($this->current->video_original_name) : null,
            'currentMimeType' => $this->current && $this->current->platform == 1 ? $this->getMimeType($this->current->video_path) : null,
        ]);
    }
}







