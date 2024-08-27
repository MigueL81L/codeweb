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
        'document' => null,
        'document_path' => null,
        'document_original_name' => null,
        'platform' => 1,
        'video' => null,
        'url' => null,
        'existing_video_path' => null,
    ];

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
            'lessonCreate.document' => 'nullable|file|mimes:pdf|max:2048',
        ];
    }

    // Método para almacenar nueva lección
    public function store() 
    {
        // Validamos las entradas
        $this->validate();

        // Acción para almacenar
        $lessonData = [
            'name' => $this->lessonCreate['name'],
            'description' => $this->lessonCreate['description'],
            'platform' => $this->lessonCreate['platform'],
            'section_id' => $this->section->id,
        ];

        try {
            // Procesa el documento solamente si existe
            if (isset($this->lessonCreate['document']) && $this->lessonCreate['document'] instanceof UploadedFile) {
                // Almacena el documento
                $lessonData['document_path'] = $this->lessonCreate['document']->store('courses/documents', 'public');
                $lessonData['document_original_name'] = $this->lessonCreate['document']->getClientOriginalName();
            } 

            // Manejo del video
            if ($lessonData['platform'] == 1 && isset($this->video) && $this->video instanceof UploadedFile) {
                // Almacena el video
                $lessonData['video_path'] = $this->video->store('courses/lessons', 'public');
                $lessonData['video_original_name'] = $this->video->getClientOriginalName();
            } elseif ($lessonData['platform'] == 2) {
                // Para YouTube
                $lessonData['video_path'] = null; 
                $lessonData['video_original_name'] = $this->url;
            }

            // Creación en la base de datos
            Lesson::create($lessonData);
            $this->reset(['url', 'lessonCreate', 'video']);
            $this->getLessons(); // Refresca la lista
            $this->emit('refreshOrderLessons');
        } catch (\Exception $e) {
            // Captura el error
            $this->dispatchBrowserEvent('notify', ['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Método de edición
    public function edit($lessonId) 
    {
        $lesson = Lesson::findOrFail($lessonId);
        // Asigna los valores actuales
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
            'description' => $lesson->description,
            'document' => $lesson->document_path ? Storage::url($lesson->document_path) : null, // Mantener la URL
            'document_path' => $lesson->document_path,
            'document_original_name' => $lesson->document_original_name,
            'platform' => $lesson->platform,
            'url' => $lesson->platform == 2 ? $lesson->video_original_name : null,
            'existing_video_path' => $lesson->platform == 1 ? $lesson->video_path : null,
        ];
    }

    // Método de actualización
    public function update() 
    {
        // Validación
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $lesson = Lesson::findOrFail($this->lessonEdit['id']);

        try {
            // Actualiza los datos
            $lesson->update([
                'name' => $this->lessonEdit['name'],
                'description' => $this->lessonEdit['description'],
            ]);

            // Solo intentar guardar el documento si uno nuevo ha sido cargado
            if (isset($this->lessonEdit['document']) && $this->lessonEdit['document'] instanceof UploadedFile) {
                // Elimina el documento viejo
                if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                    Storage::delete($lesson->document_path);
                }

                // Almacena nuevo documento
                $lesson->document_path = $this->lessonEdit['document']->store('courses/documents', 'public');
                $lesson->document_original_name = $this->lessonEdit['document']->getClientOriginalName();
            }

            // Manejo del video
            if ($lesson->platform == 1 && isset($this->lessonEdit['video']) && $this->lessonEdit['video'] instanceof UploadedFile) {
                // Elimina el video viejo si hay uno
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                // Almacena nuevo video
                $lesson->video_path = $this->lessonEdit['video']->store('courses/lessons', 'public');
                $lesson->video_original_name = $this->lessonEdit['video']->getClientOriginalName();
            } elseif ($lesson->platform == 2) {
                // Si es vídeo de YouTube
                $lesson->video_path = null; 
                $lesson->video_original_name = $this->lessonEdit['url'];
            }

            $lesson->save();
            $this->reset('lessonEdit');
            $this->getLessons();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Método de eliminación
    public function destroy($lessonId) 
    {
        $lesson = Lesson::findOrFail($lessonId);

        // Eliminar el video relacionado
        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        // Eliminar el documento relacionado
        if ($lesson->document_path && Storage::exists($lesson->document_path)) {
            Storage::delete($lesson->document_path);
        }

        // Eliminar la lección en sí
        $lesson->delete();
        $this->getLessons();
        $this->emit('refreshOrderLessons'); // Refrescar la lista
    }

    // Rendirizar la vista
    public function render() 
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}



















































