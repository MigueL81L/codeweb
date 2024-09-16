<?php  

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\User;

class CourseIndex extends Component
{
    use WithPagination;

    //Página para el reseteo a la página 1
    public $page;

    //Propiedades level
    public $selectedLevels=[];
    public $selectedLevel= null;
    public $a=null;

    //Propiedades Category
    public $selectedCategories=[];
     public $selectedCategory= null;
     public $f=null;

    //Propiedades de debugging level
    public $b=null;
    public $c=null;

    //Propiedades de debugging Category
    public $g=null;

    //Propiedad reseteo
    public $w=true;


    //Métodos de reseteo, para alicar en el cambio de filtro, de level a category y vicev
    public function resetLevel()
    {
        $this->selectedLevels = [];
        $this->selectedLevel = null;
        $this->a = null; 
    }
    
    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
        $this->f = null;
    }
    
    //Método para ir a la colección completa de courses, al pulsar el boton de reseteo
    public function resetFilters(){
        $this->w=false;
    }

    public function render()
{
    $levels = Level::all();
    $categories = Category::all();
    $mensaje = "";

    // Colección paginada única
    $coursesQuery = Course::query()->where('status', 3);

    if (!is_null($this->a)) {
        // Filtrar por nivel si está presente
        $coursesQuery->whereHas('level', function ($query) {
            $query->where('id', $this->a);
        });
        
        if ($coursesQuery->count() === 0) {
            $mensaje = "Todavía no tenemos Cursos de ese Nivel. En breve podrás disponer de los mejores!";
        }
    }
    
    if (!is_null($this->f)) {
        // Filtrar por categoría si está presente
        $coursesQuery->whereHas('category', function ($query) {
            $query->where('id', $this->f);
        });
        
        if ($coursesQuery->count() === 0) {
            $mensaje = "Todavía no tenemos Cursos de esta Categoría. En breve podrás disponer de los mejores!";
        }
    }

    // Obtener cursos paginados
    $courses = $coursesQuery->latest('id')->paginate(8);

    return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
}


    //Método que recoge los datos que le envía la vista, y se asegura que sea un array
    public function filterLevels(){

        // Resetea filtro de categoría antes de aplicar filtro de nivel
        $this->resetCategory();

        // Convertir a array si es una cadena
        if (!is_array($this->selectedLevels)) {
        $this->selectedLevels = ($this->selectedLevels !== '') ? [$this->selectedLevels] : [] ;
        }


        foreach ($this->selectedLevels as $level) {
            if($level!=null && $level != ''){
                $i=(int) $level; 
                $l = Level::find($i); 
                $this->selectedLevel = $l;
                break; // Salir del bucle después de asignar el valor válido
            }
        }

        if ($this->selectedLevel) {
            $this->a = $this->selectedLevel->id;
        } else {
            $this->a = null;
        }

        $filteredCourses = collect();

        if ($this->a != null) {
            $filteredCourses = Course::whereHas('level', function ($query) {
                $query->where('id', $this->a);
            })->paginate(8);
        }

        // Asignar a la nueva propiedad
        $this->b=count($filteredCourses);
        
        // Resetear la página después de aplicar los filtros        
        $this->resetPage(); 
        return $filteredCourses;
    }


    //Método para manejar la actualización de levels seleccionados
    public function updatedSelectedLevels(){
        $this->resetPage(); //Resetea la paginación al actualizar los levels seleccionados
    }


    //Método para obtener todos los courses publicados en la bbdd
    protected function getFilteredCourses()
    {
        return Course::where('status', 3)
            ->latest('id')
            ->paginate(8);

    }


    //Categorías
    public function filterCategories(){

        // Resetea filtro de nivel antes de aplicar filtro de categoría
        $this->resetLevel();

        // Convertir a array si es una cadena
        if (!is_array($this->selectedCategories)) {
        $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [] ;
        }


        foreach ($this->selectedCategories as $category) {
            if($category!=null && $category != ''){
                $y = Category::find($category); 
                $this->selectedCategory = $y;
                break; // Salir del bucle después de asignar el valor válido
            }
        }

        if ($this->selectedCategory) {
            $this->f = $this->selectedCategory->id;
        } else {
            $this->f = null;
        }

        $filteredCourses = collect();

        if ($this->f != null) {
            $filteredCourses = Course::whereHas('category', function ($query) {
                $query->where('id', $this->f);
            })->paginate(8);
        }
        $this->g=count($filteredCourses);
        
        // Resetear la página después de aplicar los filtros        
        $this->resetPage(); 
        return $filteredCourses;
    }


    //Método para manejar la actualización de levels seleccionados
    public function updatedSelectedCategories(){
        $this->resetPage(); //Resetea la paginación al actualizar los levels seleccionados
    }


}


