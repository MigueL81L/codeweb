<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Course;
use App\Models\Goal;

class Goals extends Component
{
    public $course;
    public $goals;
    #[Validate('required|string|max:255')]
    public $name;

    

    //Cada vez que se inicialice un componente lo primero que se inicilizará será el método mount()
    public function mount()
    { 
        //Traeme todas las metas cuyo course_id del curso asociado, coincida con el 
        //que estoy editando. Creame la colección
        $this->goals=Goal::where('course_id', $this->course->id)
                ->orderBy('position', 'asc')
                ->get()->toArray();
    }

    public function store()
    {
        $this->validate();

        //Creo un registro de meta, utilizando relaciones entre tablas
        //Vinculará la nueva meta, a su correspondiente curso, a través del course_id
        $this->course->goals()->create(['name'=>$this->name]);

        $this->goals=Goal::where('course_id', $this->course->id)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();

        $this->reset('name');
    }
    


    public function update()
    {
        $this->validate([
            //Todos los elementos del array goals, su campo name, debe ser obligatorio, string, y 
            //de no más de 255 caracteres. Solo en ese caso se cumple la validación
            'goals.*.name'=>'required|string|max:255'
        ]);

        foreach ($this->goals as $goal) 
        {
            //Recorre el array de metas correspondiente al curso, y actualiza aquel 
            //que coincida el id. Actualiza el nombre
            Goal::find($goal['id'])->update([
                'name'=>$goal['name'],
            ]);
        }
        //Evento swal definido en instructor.blade.php con sweetalert2
        $this->dispatch('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'Las metas del curso han sido actualizadas correctamente',
        ]);
    }

    public function destroy($goalId)
    {
        Goal::find($goalId)->delete();
        $this->goals=Goal::where('course_id', $this->course->id)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();
    }

    public function sortGoals($data)
    {
        //Actualización de la posición
        foreach ($data as $index=>$goalId) {
            Goal::find($goalId)->update([
                'position'=>$index+1
            ]);
        }

        //Refresco
        $this->goals=Goal::where('course_id', $this->course->id)
        ->orderBy('position', 'asc')
        ->get()->toArray();
    }

    public function render()
    {
        return view('livewire.instructor.courses.goals');
    }
}
