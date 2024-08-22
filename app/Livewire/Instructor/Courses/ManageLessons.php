<?php

namespace App\Livewire\Instructor\Courses;

use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ManageLessons extends Component
{
    use WithFileUploads;

    public $section;
    public $lessons;
    public $video;
    public $url;
    public $document;

    public $lessonCreate = [
        'open' => false,
        'name' => null,
        'platform' => 1,
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
        'platform' => 1,
        'video' => null,
        'url' => null,
        'video_original_name' => null,
        'existing_video_path' => null,
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
            'lessonCreate.platform' => 'required|in:1,2',
            'lessonCreate.description' => 'nullable|string',
            'lessonCreate.document' => 'nullable|mimes:pdf|max:2048',
            'lessonEdit.name' => 'required',
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:2048',
            'lessonEdit.platform' => 'required|in:1,2',
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

        if ($this->lessonCreate['platform'] == 1 && $this->video instanceof UploadedFile) {
            $this->lessonCreate['video_path'] = $this->video->store('courses/lessons');
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
        } elseif ($this->lessonCreate['platform'] == 2 && $this->url) {
            $this->lessonCreate['video_path'] = null;
            $this->lessonCreate['video_original_name'] = $this->url;
        }

        $lesson = $this->section->lessons()->create($this->lessonCreate);

        $this->reset(['lessonCreate', 'video', 'document']);
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
            'description' => $lesson->description,
            'document' => null,
            'document_path' => $lesson->document_path,
            'document_original_name' => $lesson->document_original_name,
            'platform' => $lesson->platform,
            'url' => $lesson->platform == 2 ? $lesson->video_original_name : null,
            'existing_video_path' => $lesson->platform == 1 ? $lesson->video_path : null,
        ];
    }

    public function update()
    {
        $this->validate();

        // Obtener lección actual desde la base de datos
        $lesson = Lesson::find($this->lessonEdit['id']);

        // Actualizar información textual de la lección
        $lesson->update([
            'name' => $this->lessonEdit['name'],
            'description' => $this->lessonEdit['description'],
            'platform' => $this->lessonEdit['platform'],
        ]);

        // Manejo de archivo de documento
        if ($this->lessonEdit['document'] instanceof UploadedFile) {
            $document = $this->lessonEdit['document'];
            if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                Storage::delete($lesson->document_path);
            }

            $lesson->document_path = $document->store('courses/documents');
            $lesson->document_original_name = $document->getClientOriginalName();
        }

        // Manejo de video
        if ($this->lessonEdit['platform'] == 1 && $this->lessonEdit['video'] instanceof UploadedFile) {
            // Si cambiamos de YouTube a archivo local y hay un video_path, eliminarlo
            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
            }
            $lesson->video_path = $this->lessonEdit['video']->store('courses/lessons');
            $lesson->video_original_name = $this->lessonEdit['video']->getClientOriginalName();
        } elseif ($this->lessonEdit['platform'] == 2 && $this->lessonEdit['url']) {
            // Si cambiamos de archivo local a YouTube y hay un video_path, eliminarlo
            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
            }
            $lesson->video_path = null;
            $lesson->video_original_name = $this->lessonEdit['url'];
        }

        $lesson->save();

        $this->reset('lessonEdit');
        $this->getLessons();
    }

    public function sortLessons($order)
    {
        foreach ($order as $index => $lessonId) {
            Lesson::find($lessonId)->update(['position' => $index + 1]);
        }
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function destroy($lessonId)
    {
        $lesson = Lesson::find($lessonId);

        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        if ($lesson->document_path && Storage::exists($lesson->document_path)) {
            Storage::delete($lesson->document_path);
        }

        $lesson->delete();
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}
























