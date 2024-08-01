<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Course;
use App\Models\Requirement;

class Requirements extends Component
{
    public $course;
    public $requirements;

    #[Validate('required|string|max:255')]
    public $name;

    //Cada vez que se inicialice un componente lo primero que se inicilizará será el método mount()
        public function mount()
    { 
        //Traeme todas las metas cuyo course_id del curso asociado, coincida con el 
        //que estoy editando. Creame la colección
        $this->requirements=Requirement::where('course_id', $this->course->id)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();
    }


    public function store()
    {
        $this->validate();

        //Creo un registro de meta, utilizando relaciones entre tablas
        //Vinculará la nueva meta, a su correspondiente curso, a través del course_id
        $this->course->requirements()->create(['name'=>$this->name]);

        $this->requirements=Requirement::where('course_id', $this->course->id)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();

        $this->reset('name');
    }


    public function update()
    {
        $this->validate([
            //Todos los elementos del array goals, su campo name, debe ser obligatorio, string, y 
            //de no más de 255 caracteres. Solo en ese caso se cumple la validación
            'requirements.*.name'=>'required|string|max:255'
        ]);

        foreach ($this->requirements as $requirement) 
        {
            //Recorre el array de metas correspondiente al curso, y actualiza aquel 
            //que coincida el id. Actualiza el nombre
            Requirement::find($requirement['id'])->update([
                'name'=>$requirement['name'],
            ]);
        }
        //Evento swal definido en instructor.blade.php con sweetalert2
        $this->dispatch('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'Los requerimientos del curso han sido actualizados correctamente',
        ]);
    }

    public function destroy($requirementId)
    {
        Requirement::find($requirementId)->delete();
        $this->requirements=Requirement::where('course_id', $this->course->id)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();
    }

    public function sortRequirements($data)
    {
        //Actualización de la posición
        foreach ($data as $index=>$requirementId) {
            Requirement::find($requirementId)->update([
                'position'=>$index+1
            ]);
        }

        //Refresco
        $this->requirements=Requirement::where('course_id', $this->course->id)
        ->orderBy('position', 'asc')
        ->get()->toArray();
    }


    public function render()
    {
        return view('livewire.instructor.courses.requirements');
    }
}
