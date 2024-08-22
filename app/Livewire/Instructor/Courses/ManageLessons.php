<?php

namespace App\Livewire\Instructor\Courses;

use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class ManageLessons extends Component
{
    use WithFileUploads;

    public $section;
    public $lessons;
    public $video;
    public $url;

    public $lessonCreate = [
        'open' => false,
        'name' => null,
        'description' => null,
        'document' => null,
        'document_original_name' => null,
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
        'description' => null,
        'document' => null,
        'document_path' => null,
        'document_original_name' => null,
        'video' => null,
        'url' => null,
        'video_original_name' => null,
        'video_path' => null,
    ];

    public $orderLessons;

    protected $listeners = ['refreshOrderLessons' => 'getLessons'];

    public function mount()
    {
        $this->getLessons();
    }

    public function getLessons()
    {
        $this->lessons = Lesson::where('section_id', $this->section->id)
            ->orderBy('position', 'asc')
            ->get();
    }

    public function rules() 
    {
        return [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.document' => 'nullable|mimes:pdf|max:2048',
        ];
    }

    public function store() 
    {
        $this->validate();
        $this->lessonCreate['section_id'] = $this->section->id;

        if ($this->lessonCreate['document'] instanceof UploadedFile) {
            $document = $this->lessonCreate['document'];
            $this->lessonCreate['document_path'] = $document->store('courses/documents');
            $this->lessonCreate['document_original_name'] = $document->getClientOriginalName();
        }

        if ($this->video instanceof UploadedFile) {
            $this->lessonCreate['video_path'] = $this->video->store('courses/lessons');
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
        } elseif (!empty($this->url)) {
            $this->lessonCreate['video_path'] = null;
            $this->lessonCreate['video_original_name'] = $this->url;
        }

        $lesson = $this->section->lessons()->create($this->lessonCreate);

        $this->reset(['url', 'lessonCreate', 'video']);
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
            'description' => $lesson->description,
            'document' => null,
            'document_path' => $lesson->document_path,
            'document_original_name' => $lesson->document_original_name,
            'video_original_name' => $lesson->video_original_name,
            'video_path' => $lesson->video_path,
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $lesson = Lesson::findOrFail($this->lessonEdit['id']);

            // Manejo de documento
            if ($this->lessonEdit['document'] instanceof UploadedFile) {
                if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                    Storage::delete($lesson->document_path);
                }
                $lesson->document_path = $this->lessonEdit['document']->store('courses/documents');
                $lesson->document_original_name = $this->lessonEdit['document']->getClientOriginalName();
            }

            // Manejo de video
            if ($this->video instanceof UploadedFile) {
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                $lesson->video_path = $this->video->store('courses/lessons');
                $lesson->video_original_name = $this->video->getClientOriginalName();
            } elseif (!empty($this->url)) {
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                $lesson->video_path = null;
                $lesson->video_original_name = $this->url;
            }

            $lesson->update([
                'name' => $this->lessonEdit['name'],
                'description' => $this->lessonEdit['description'],
                'video_path' => $lesson->video_path,
                'video_original_name' => $lesson->video_original_name,
                'document_path' => $lesson->document_path,
                'document_original_name' => $lesson->document_original_name,
            ]);

            $this->reset('lessonEdit');
            $this->getLessons();
        } catch (Exception $e) {
            Log::error("Error actualizando lección: " . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un problema al actualizar la lección: ' . $e->getMessage());
        }
    }

    public function sortLessons($order)
    {
        foreach ($order as $index => $lessonId) {
            Lesson::where('id', $lessonId)->update(['position' => $index + 1]);
        }
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function destroy($lessonId)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);

            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
            }

            if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                Storage::delete($lesson->document_path);
            }

            $lesson->delete();
            $this->getLessons();
            $this->emit('refreshOrderLessons');
        } catch (Exception $e) {
            Log::error("Error eliminando lección: " . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un problema al eliminar la lección: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}






























