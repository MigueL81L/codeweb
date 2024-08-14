<?php

namespace App\Livewire\Instructor\Courses;

use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Events\VideoUploaded; // Importa el evento
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage de Laravel
use Illuminate\Support\Facades\Log;

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
        'platform' => 1, // 1 Significa video normal
        'video_original_name' => null,
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,

        'description'=>null,
    ];

    // Definida en el método getLessons() de ManageSections.php
    public $orderLessons;  

    // Método de refresco
    public function getLessons()
    {
        // Todas las lecciones que le corresponden a la sección
        $this->lessons = Lesson::where('section_id', $this->section->id)
            ->orderBy('position', 'asc')
            ->get();
    }

    public function rules()
    {
        $rules = [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.platform' => 'required',
        ];
    
        if ($this->lessonCreate['platform'] == 1) {
            // Aumentar el tamaño del archivo a 250MB = 250 * 1024 KB = 256000 KB
            $rules['video'] = 'required|file|mimes:mp4,mov,avi,wmv,flv,3gp|max:256000'; 
        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }
    
        return $rules;
    }

    public function store()
    {
        Log::info('Inicio del proceso de almacenamiento de lección.');
    
        $this->validate();
        Log::info('Validación completada con éxito.');
    
        $this->lessonCreate['section_id'] = $this->section->id;
    
        if ($this->lessonCreate['platform'] == 1) {
            Log::info('Plataforma seleccionada: Video normal.');
    
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
            Log::info('Nombre original del video:', [$this->lessonCreate['video_original_name']]);
    
            if ($this->video) {
                Log::info('Archivo de video disponible para cargar.');
    
                try {
                    $temporaryFilePath = $this->video->store('courses/lessons', 'public');
                    Log::info('Video subido exitosamente.', [$temporaryFilePath]);
    
                    $lesson = $this->section->lessons()->create($this->lessonCreate);
                    $lesson->video_path = $temporaryFilePath;
                    $lesson->save();
                    Log::info('Lección creada y video_path guardado.', ['lesson_id' => $lesson->id]);
                } catch (\Exception $e) {
                    Log::error('Error subiendo video:', [$e->getMessage()]);
                }
            } else {
                Log::warning('No se encontró archivo de video para cargar.');
            }
        } else {
            Log::info('Plataforma seleccionada: YouTube.');
            
            $this->lessonCreate['video_original_name'] = $this->url;
            $lesson = $this->section->lessons()->create($this->lessonCreate);
            Log::info('Lección creada con video de YouTube.', ['lesson_id' => $lesson->id]);
        }
    
        VideoUploaded::dispatch($lesson);
        Log::info('Evento VideoUploaded despachado.');
    
        $this->reset(['url', 'lessonCreate', 'video']);
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
        
        Log::info('Completados los pasos finales y interfaz de usuario actualizada.');
    }
    
    

    public function edit($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,

            'description'=>$lesson->description,
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
        ]);

        // Actualizo la lección
        Lesson::find($this->lessonEdit['id'])->update([
            'name' => $this->lessonEdit['name'],
            'description' => $this->lessonEdit['description'],
        ]);

        // Reinicio los datos de edición
        $this->reset('lessonEdit');
        $this->getLessons();
    }

    // Método para ordenar lecciones
    public function sortLessons($order)
    {
         foreach ($order as $index => $lessonId) {
            Lesson::find($lessonId)->update(['position' => $index + 1]);
        }

        // Refrescar lista de lecciones
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
    
        // Verificar y eliminar la imagen de portada asociada a la lección (si aplica)
        if ($lesson->image_path && Storage::exists($lesson->image_path)) {
            Storage::delete($lesson->image_path);
        }
    
        // Eliminar la lección de la base de datos
        $lesson->delete();
    
        // Actualizar la lista de lecciones
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
    }
    

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');  
    }
}









