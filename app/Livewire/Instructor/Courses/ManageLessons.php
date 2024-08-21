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
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
        'description' => null,
        'document_path' => null, // Agregar campo para documento
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
        $rules = [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.platform' => 'required',
            'lessonCreate.description' => 'nullable|string', 
            'lessonCreate.document' => 'nullable|mimes:pdf|max:2048',
        ];

        return $rules;
    }

    public function store()
    {
        $this->validate();
        $this->lessonCreate['section_id'] = $this->section->id;

        // Manejo de la subida del documento
        if ($this->lessonCreate['document']) {
            $this->lessonCreate['document_path'] = $this->lessonCreate['document']->store('courses/documents');
        }

        if ($this->lessonCreate['platform'] == 1) {
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
        } else {
            $this->lessonCreate['video_original_name'] = $this->url;
        }

        // Crear la lección
        $lesson = $this->section->lessons()->create($this->lessonCreate);

        // Manejo de la subida del video
        if ($this->lessonCreate['platform'] == 1 && $this->video) {
            $lesson->video_path = $this->video->store('courses/lessons');
            $lesson->save();
        }

        if (isset($this->lessonCreate['document_path'])) {
            $lesson->document_path = $this->lessonCreate['document_path'];
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
            'document_path' => $lesson->document_path, // Cargar el document_path
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document_path' => 'nullable|mimes:pdf|max:2048', // Validar nuevo documento si se cambia
        ]);

        // Actualizar la lección
        $lesson = Lesson::find($this->lessonEdit['id']);

        $lesson->update([
            'name' => $this->lessonEdit['name'],
            'description' => $this->lessonEdit['description'],
        ]);

        // Manejo de la subida de un nuevo documento
        if ($this->lessonEdit['document']) {
            // Eliminar el documento anterior si existe
            if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                Storage::delete($lesson->document_path);
            }
            // Guardar el nuevo documento y actualizar el model
            $lesson->document_path = $this->lessonEdit['document']->store('courses/documents');
            $lesson->save();
        }

        // Reiniciar los datos de edición
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

        // Verificar y eliminar el video asociado a la lección
        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        // Verificar y eliminar el documento
        if ($lesson->document_path && Storage::exists($lesson->document_path)) {
            Storage::delete($lesson->document_path);
        }

        // Eliminar la lección
        $lesson->delete();
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');   
    }
}










