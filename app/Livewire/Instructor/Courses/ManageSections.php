<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use App\Models\Section;
use App\Models\Course;

class ManageSections extends Component
{
    public $course;
    public $name;
    public $sections;
    public $sectionEdit = [
        'id' => null,
        'name' => null,
    ];
    public $sectionPositionCreate = [];
    public $orderLessons;

    // Escuchar el evento 'refreshOrderLessons' y enlazarlo al método 'getSections'
    protected $listeners = ['refreshOrderLessons' => 'getSections'];

    // Cada vez que se inicialice un componente, lo primero que se inicializará será el método mount()
    public function mount()
    {
        // Trae todas las secciones cuyo course_id del curso asociado, coincida con el 
        // que estoy editando. Crea la colección
        $this->getSections();
    }

    // Método de refresco. Debe capturar todas las secciones y lecciones del curso 
    public function getSections()
    {
        $this->sections = Section::where('course_id', $this->course->id)
            ->with(['lessons' => function ($query) {
                $query->orderBy('position', 'asc');
            }])
            ->orderBy('position', 'asc')
            ->get();

        $this->orderLessons = $this->sections
            ->pluck('lessons')
            ->collapse()
            ->pluck('id');
    }

    public function store()
    {
        $this->validate(['name' => 'required']);

        // Creación de la sección a través de la relación de modelos, asociándolo al id del curso
        $this->course->sections()->create(['name' => $this->name]);

        // Refresco la colección de secciones
        $this->getSections();

        // Una vez creada la sección, resetea el valor de name
        $this->reset('name');
    }

    public function storePosition($sectionId)
    {
        $this->validate(["sectionPositionCreate.{$sectionId}.name" => 'required']);

        $position = Section::find($sectionId)->position;

        Section::where('course_id', $this->course->id)
            ->where('position', '>=', $position)
            ->increment('position');

        $this->course->sections()->create([
            'name' => $this->sectionPositionCreate[$sectionId]['name'],
            'position' => $position
        ]);

        // Refresco y reseteo
        $this->getSections();
        $this->reset("sectionPositionCreate.{$sectionId}");

        // Disparo de evento de cierre del modal
        $this->dispatch('close-section-position-create');
    }

    public function edit(Section $section)
    {
        $this->sectionEdit = [
            'id' => $section->id,
            'name' => $section->name,
        ];
    }

    public function update()
    {
        $this->validate(['sectionEdit.name' => 'required']);
        // Busca la sección cuya propiedad sectionEdit tenga este id,
        // y actualiza su nombre, por el que insertó el usuario
        Section::find($this->sectionEdit['id'])->update([
            'name' => $this->sectionEdit['name']
        ]);
        $this->reset('sectionEdit');

        // Refresco la colección de secciones
        $this->getSections();
    }

    public function destroy(Section $section)
    {
        $section->delete();

        // Refresco la colección de secciones
        $this->getSections();

        $this->dispatch('swal', [
            "icon" => "success",
            "title" => "Eliminado!",
            "text" => "La sección ha sido eliminada.",
        ]);
        $this->getSections();
    }

    public function sortSections($sorts)
    {
        foreach ($sorts as $position => $sectionId) {
            Section::find($sectionId)->update(['position' => $position + 1]);
            $this->getSections();
        }
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-sections');
    }
}



