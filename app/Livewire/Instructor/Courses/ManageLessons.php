<?php

namespace App\Livewire\Instructor\Courses;

use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Events\VideoUploaded; // Importa el evento
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage de Laravel

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
            $rules['video'] = 'required|mimes:mp4,mov,avi,wmv,flv,3gp';
        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }

        return $rules;
    }

    public function store()
    {
        $this->validate();

        $this->lessonCreate['section_id'] = $this->section->id;

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

        VideoUploaded::dispatch($lesson);

        $this->reset(['url', 'lessonCreate', 'video']);
        $this->getLessons();
        $this->dispatch('refreshOrderLessons');
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








