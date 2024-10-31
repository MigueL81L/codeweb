<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Lesson;
use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ManageLessons extends Component
{
    use WithFileUploads;

    public $section;
    public $lessons;
    public $video;
    public $document;
    public $url;

    public $lessonCreate = [
        'open' => false,
        'name' => null,
        'platform' => 1,
        'description' => null,
        'document' => null,

        'video' => null,
        'url' => null,
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
        'description' => null,
        'document' => null,
        'document_original_name' => null,
        'document_path' => null,
        'platform' => 1,
        'video' => null,
        'url' => null,
        'existing_video_path' => null,
    ];

    protected $listeners = ['refreshOrderLessons' => 'getLessons'];

    public function mount()
    {
        Log::info('Método mount iniciado');
        $this->getLessons();
        Log::info('Método mount finalizado');
    }

    public function getLessons()
    {
        Log::info('Método getLessons iniciado');
        $this->lessons = Lesson::where('section_id', $this->section->id)
            ->orderBy('position')
            ->get();
        Log::info('Lecciones obtenidas: ' . $this->lessons->count());
    }

    public function rules()
    {
        Log::info('Validación iniciada');
    
        return [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.platform' => 'required|in:1,2',
            'lessonCreate.description' => 'nullable|string',
    
            // Debería elevar el tamaño máximo de los documents. Ahora 5 MB
            'lessonCreate.document' => 'nullable|file|mimes:pdf|max:5120',
            'lessonCreate.video' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,3gp|max:1331200', 
    
            'lessonEdit.video' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,3gp|max:1331200',
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }
    

    public function store()
{
    Log::info('Método store iniciado');

    $this->validate();

    // Inicializar data de la lección
    $lessonData = [
        'name' => $this->lessonCreate['name'],
        'description' => $this->lessonCreate['description'],
        'platform' => $this->lessonCreate['platform'],
        'section_id' => $this->section->id,

        // Asegúrate de asignar valores por defecto para evitar NULL
        'document_path' => null,
        'document_original_name' => null,

        'video_path' => null,
        'video_original_name' => null,
    ];

    try {
        Log::info('Intentando guardar la lección con los datos: ' . json_encode($lessonData));
        
        // Procesar el documento
        if ($this->lessonCreate['document'] instanceof UploadedFile) {
            $path = $this->lessonCreate['document']->store('courses/documents', 'public');
            $lessonData['document_path'] = $path;
            $lessonData['document_original_name'] = $this->lessonCreate['document']->getClientOriginalName();
            Log::info('Documento subido: ' . $path);
        }

        // Procesar el video
        if ($this->lessonCreate['platform'] == 1 && $this->lessonCreate['video'] instanceof UploadedFile) {
            // Almacenar el video y verificar la asignación
            $path = $this->lessonCreate['video']->store('/courses/lessons', 'public');
            if ($path) { // Verificar que se haya almacenado correctamente
                $lessonData['video_path'] = $path;
                $lessonData['video_original_name'] = $this->lessonCreate['video']->getClientOriginalName();
                Log::info('Video subido: ' . $lessonData['video_path']);
            } else {
                Log::warning('No se pudo guardar el video.');
            }
        } elseif ($this->lessonCreate['platform'] == 2) {
            $lessonData['video_path'] = null; // No hay video en el caso de YouTube
            $lessonData['video_original_name'] = $this->lessonCreate['url'];
            Log::info('Se está utilizando URL de YouTube: ' . $this->lessonCreate['url']);
        }

        // Crear la lección en la base de datos
        Lesson::create($lessonData);
        Log::info('Lección creada correctamente.');

        // Resetear los campos después de crear
        $this->reset(['lessonCreate', 'video', 'document', 'url']);
        
        // Obtener las lecciones otra vez para asegurar que la vista esté actualizada
        $this->getLessons();

    } catch (\Exception $e) {
        Log::error('Error al guardar la lección: ' . $e->getMessage());
        session()->flash('error', 'Error al guardar la lección: ' . $e->getMessage());
    }
}

    
    public function edit($lessonId)
    {
        Log::info('Método edit iniciado para la lección ID: ' . $lessonId);
        $lesson = Lesson::findOrFail($lessonId);
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
        Log::info('Lección editada con éxito: ' . json_encode($this->lessonEdit));
    }

    public function update()
    {
        Log::info('Método update iniciado');
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:5120',
            'lessonEdit.video' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,3gp|max:1331200',
        ]);
        
        Log::info('Validación completada para la actualización.');
        $lesson = Lesson::findOrFail($this->lessonEdit['id']);
        
        try {
            Log::info('Actualizando lección ID: ' . $this->lessonEdit['id']);
            $lesson->update([
                'name' => $this->lessonEdit['name'],
                'description' => $this->lessonEdit['description'],
            ]);

            // Captura de los documentos y videos en variables internas
            $uploadedDocument = $this->lessonEdit['document'] ?? null; // Usar null como valor por defecto
            $uploadedVideo = $this->lessonEdit['video'] ?? null;

            // Verificación para eliminar y actualizar el documento
            if ($uploadedDocument instanceof UploadedFile) {
                // Eliminar el documento anterior si existe
                if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                    Storage::delete($lesson->document_path);
                    Log::info('Documento anterior eliminado: ' . $lesson->document_path);
                }
                $lesson->document_path = $uploadedDocument->store('courses/documents', 'public');
                $lesson->document_original_name = $uploadedDocument->getClientOriginalName();
                Log::info('Documento nuevo subido: ' . $lesson->document_path);
            }

            // Verificación para eliminar y actualizar el video
            if ($lesson->platform == 1 && $uploadedVideo instanceof UploadedFile) {
                // Eliminar el video anterior si existe
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                    Log::info('Video anterior eliminado: ' . $lesson->video_path);
                }
                $lesson->video_path = $uploadedVideo->store('courses/lessons', 'public');
                $lesson->video_original_name = $uploadedVideo->getClientOriginalName();
                Log::info('Video nuevo subido: ' . $lesson->video_path);
            } elseif ($lesson->platform == 2) {
                // Si se está usando YouTube
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                    Log::info('Video anterior eliminado (YouTube): ' . $lesson->video_path);
                }
                $lesson->video_path = null;
                $lesson->video_original_name = $this->lessonEdit['url'] ?? null; // Asegúrate de que este campo existe también
            }

            $lesson->save(); // Guardar los cambios después de manipular los archivos
            Log::info('Lección actualizada correctamente.');

            $this->reset('lessonEdit');
            $this->getLessons();

        } catch (\Exception $e) {
            Log::error('Error al actualizar la lección: ' . $e->getMessage());
            // $this->dispatchBrowserEvent('notify', ['message' => 'Error: ' . $e->getMessage()]);
            session()->flash('error', 'Error al actualizar la lección: ' . $e->getMessage());
        }
    }

    public function sortLessons($order)
    {
        Log::info('Método sortLessons iniciado con el orden: ' . json_encode($order));
        foreach ($order as $index => $lessonId) {
            Lesson::findOrFail($lessonId)->update(['position' => $index + 1]);
        }
        Log::info('Lecciones ordenadas exitosamente.');
        $this->getLessons();
        // $this->emit('refreshOrderLessons');
    }

    public function destroy($lessonId)
    {
        Log::info('Método destroy iniciado para lección ID: ' . $lessonId);
        // Buscar lección por ID
        $lesson = Lesson::findOrFail($lessonId);
        
        try {
            // Eliminar el video si existe primero para evitar problemas
            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
                Log::info('Video eliminado: ' . $lesson->video_path);
            }

            // Eliminar el documento si existe
            if ($lesson->document_path && Storage::exists($lesson->document_path)) { 
                Storage::delete($lesson->document_path);
                Log::info('Documento eliminado: ' . $lesson->document_path);
            }

            // Finalmente, eliminar la lección
            $lesson->delete();
            Log::info('Lección eliminada correctamente.');

            // Actualizar las lecciones en la interfaz tras la eliminación
            $this->getLessons();
            // $this->emit('refreshOrderLessons');

        } catch (\Exception $e) {
            // Captura de excepciones para error 500
            Log::error('Error al eliminar la lección: ' . $e->getMessage());
            // $this->dispatchBrowserEvent('notify', ['message' => 'Error al eliminar lección: ' . $e->getMessage()]);
            session()->flash('error', 'Error al eliminar la lección: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        Log::info('Método render iniciado');
        return view('livewire.instructor.courses.manage-lessons');
    }
}





























































