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

    public $course, $current;
    public $index, $previous, $next;
    public $lfs;

    public function mount(Course $course)
    {
        Log::info('mount: Method called');
        
        try {
            $this->course = $course;
            Log::info('mount: Course set with ID: ' . $course->id);
            $this->index = 0;
            $this->lfs = collect();
            Log::info('mount: Initialized lesson collection');

            foreach ($course->sections->sortBy('position') as $section) {
                Log::info('mount: Processing section ID: ' . $section->id);
                foreach ($section->lessons as $lesson) {
                    $this->lfs->push($lesson);
                    Log::info('mount: Added lesson ID: ' . $lesson->id);
                }
            }

            Log::info('mount: Total lessons collected: ' . $this->lfs->count());

            $incompleteLessons = $this->lfs->filter(function ($lesson) {
                return !$lesson->completed;
            });

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

    private function updatePrevNext()
    {
        Log::info('updatePrevNext: Updating previous and next lessons');
        $this->previous = $this->index > 0 ? $this->lfs[$this->index - 1] : null;
        $this->next = $this->index < $this->lfs->count() - 1 ? $this->lfs[$this->index + 1] : null;

        Log::info('updatePrevNext: Previous lesson set to: ' . ($this->previous->id ?? 'null'));
        Log::info('updatePrevNext: Next lesson set to: ' . ($this->next->id ?? 'null'));
    }

    private function getYoutubeEmbedUrl($url)
    {
        Log::info('getYoutubeEmbedUrl: Resolving URL: ' . $url);
        preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
        $videoId = $matches[3] ?? null;

        if ($videoId) {
            Log::info('getYoutubeEmbedUrl: Video ID resolved: ' . $videoId);
            return "https://www.youtube.com/embed/" . $videoId;
        }

        Log::info('getYoutubeEmbedUrl: No valid video ID found.');
        return $url;
    }

    private function getMimeType($path)
    {
        Log::info('getMimeType: Determining MIME type for path: ' . $path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mimeTypes = [
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'flv' => 'video/x-flv',
            '3gp' => 'video/3gpp',
        ];

        $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';
        Log::info('getMimeType: MIME type determined: ' . $mimeType);
        return $mimeType;
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
    
        $currentMimeType = null;  // Cambia de asignar a static a null
        $currentIframe = null;
    
        Log::info('Current lesson platform: ' . $this->current->platform);
    
        // Mover la lógica de tipo de video aquí
        if ($this->current) {
            if ($this->current->platform == 1 && !is_null($this->current->video_path)) {
                $currentMimeType = $this->current->getVideoType($this->current->video_original_name); // Aquí accedemos al método directamente.
                Log::info('MIME type for current lesson: ' . $currentMimeType);
            } elseif ($this->current->platform == 2) {
                $currentIframe = $this->getYoutubeEmbedUrl($this->current->video_original_name);
                Log::info('YouTube embed URL: ' . $currentIframe);
            }
        }
    
        Log::info('Rendering view with currentMimeType=' . ($currentMimeType ?? 'null'));
    
        return view('livewire.course-status', [
            'course' => $this->course,
            'current' => $this->current,
            'advance' => $this->advance,
            'currentIframe' => $currentIframe,
            'currentMimeType' => $currentMimeType, // Lo pasamos a la vista
        ]);
    }
    
}















