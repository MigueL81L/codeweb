<?php

namespace App\Livewire\Instructor\Courses;

use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Events\VideoUploaded;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

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
        'video_original_name' => null,
        'description' => null,
        'document' => null,
        'document_original_name' => null,
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
        'description' => null,
        'document' => null, // Asegura que esto esté presente
        'document_path' => null,
        'document_original_name' => null,
    ];

    public $orderLessons;

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
            'lessonCreate.platform' => 'required',
            'lessonCreate.description' => 'nullable|string',
            'lessonCreate.document' => 'nullable|mimes:pdf|max:2048',
        ];
    }

    public function store()
    {
        $this->validate();
        $this->lessonCreate['section_id'] = $this->section->id;

        // Manejo de la subida del documento
        if ($this->lessonCreate['document']) {
            $this->lessonCreate['document_path'] = $this->lessonCreate['document']->store('courses/documents');
            $this->lessonCreate['document_original_name'] = $this->lessonCreate['document']->getClientOriginalName();
        }

        if ($this->lessonCreate['platform'] == 1) {
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
        } else {
            $this->lessonCreate['video_original_name'] = $this->url;
        }

        $lesson = $this->section->lessons()->create($this->lessonCreate);

        if ($this->lessonCreate['platform'] == 1 && $this->video) {
            $lesson->video_path = $this->video->store('courses/lessons');
            $lesson->save();
        }

        if (isset($this->lessonCreate['document_path'])) {
            $lesson->document_path = $this->lessonCreate['document_path'];
            $lesson->document_original_name = $this->lessonCreate['document_original_name'];
            $lesson->save();
        }

        VideoUploaded::dispatch($lesson);
        $this->reset(['url', 'lessonCreate', 'video', 'document']);
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
            'description' => $lesson->description,
            'document' => null, // Indica que estamos sólo editando, no cargando un nuevo archivo
            'document_path' => $lesson->document_path,
            'document_original_name' => $lesson->document_original_name,
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document' => 'nullable|mimes:pdf|max:2048',
        ]);

        $lesson = Lesson::find($this->lessonEdit['id']);

        $lesson->update([
            'name' => $this->lessonEdit['name'],
            'description' => $this->lessonEdit['description'],
        ]);

        // Manejo de la subida de un nuevo documento
        if ($this->lessonEdit['document']) {
            if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                Storage::delete($lesson->document_path);
            }
            $lesson->document_path = $this->lessonEdit['document']->store('courses/documents');
            $lesson->document_original_name = $this->lessonEdit['document']->getClientOriginalName();
            $lesson->save();
        }

        $this->reset('lessonEdit');
        $this->getLessons();
    }

    public function sortLessons($order)
    {
        foreach ($order as $index => $lessonId) {
            Lesson::find($lessonId)->update(['position' => $index + 1]);
        }
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
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
        $this->dispatch('refreshOrderLessons');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}













