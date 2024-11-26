<?php  

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use App\Models\Price; // Asegúrate de tener este modelo
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\User;

class CourseIndex extends Component
{
    use WithPagination;

    public $page;

    public $selectedLevels = [];
    public $selectedLevel = null;
    public $a = null;

    public $selectedCategories = [];
    public $selectedCategory = null;
    public $f = null;

    public $selectedPrices = [];
    public $selectedPrice = null;
    public $p = null;
    public $isFiltered = false;

    public function resetLevel()
    {
        $this->selectedLevels = [];
        $this->selectedLevel = null;
        $this->a = null; 

    // Eliminar únicamente el filtro de niveles
    if (is_null($this->f) && is_null($this->p)) { // Si no hay otros filtros activos
        $this->isFiltered = false;
    }

        $this->resetPage(); 
    }
    
    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
        $this->f = null;

    // Eliminar únicamente el filtro de categorías
    if (is_null($this->a) && is_null($this->p)) { // Si no hay otros filtros activos
        $this->isFiltered = false;
    }

        $this->resetPage(); 
    }
    
    public function resetPrice()
    {
        $this->selectedPrices = [];
        $this->selectedPrice = null;
        $this->p = null;

    // Eliminar únicamente el filtro de precios
    if (is_null($this->a) && is_null($this->f)) { // Si no hay otros filtros activos
        $this->isFiltered = false;
    }

        $this->resetPage(); 
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $prices = Price::all(); // Obtener precios

        $mensaje = "";
    
        $coursesQuery = Course::where('status', 3);


          // Aplicar filtros si están presentes
        if ($this->isFiltered) {

            // Filtrado por nivel
            if (!is_null($this->a)) {
                $coursesQuery->whereHas('level', function ($query) {
                    $query->where('id', $this->a);
                });
            }
            
            // Filtrado por categoría
            if (!is_null($this->f)) {
                $coursesQuery->whereHas('category', function ($query) {
                    $query->where('id', $this->f);
                });
            }

            // Filtrado por precio
            if (!is_null($this->p)) {
                $coursesQuery->whereHas('price', function ($query) {
                    $query->where('id', $this->p);
                });
            }
            
            // Comprobar si hay resultados después de aplicar los filtros
            if ($coursesQuery->count() === 0) {
                $mensaje = "No hay cursos disponibles con los criterios seleccionados.";
            } 
            
            // Obtener cursos filtrados sin paginación
            $courses = $coursesQuery->latest('id')->get();
            
        } else {
            // Si no hay filtros, paginar la colección completa
            $courses = $coursesQuery->latest('id')->paginate(8)->withQueryString();
        }

    
        return view('livewire.course-index', [
            'levels' => $levels,
            'categories' => $categories,
            'prices' => $prices,
            'courses' => $courses,
            'mensaje' => $mensaje,
        ]);
    }
    
public function filterLevels()
{
    // Reiniciar a la primera página
    $this->page = 1;

    // Limpiar otros filtros
    $this->resetCategory(); 
    $this->resetPrice(); 

    // Si selecciona múltiples niveles y asegura que se manejen como tal
    if (!is_array($this->selectedLevels)) {
        $this->selectedLevels = ($this->selectedLevels !== '') ? [$this->selectedLevels] : [];
    }

    // Obtener el primer nivel seleccionado
    $this->selectedLevel = count($this->selectedLevels) > 0 ? Level::find($this->selectedLevels[0]) : null;

    // Establecer la variable `a` basada en la selección actual
    $this->a = $this->selectedLevel ? $this->selectedLevel->id : null;

    // Establecer `isFiltered` a verdadero porque estamos aplicando un filtro
    $this->isFiltered = !is_null($this->a);

    // Reiniciar la paginación
    $this->resetPage(); 
}

    public function updatedSelectedLevels()
    {
        $this->resetPage();
    }


    public function filterCategories()
    {
        // Reiniciar a la primera página
        $this->page = 1;
    
        // Limpiar otros filtros
        $this->resetLevel(); 
        $this->resetPrice(); 
    
        // Si selecciona múltiples categorías y asegura que se manejen como tal
        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [];
        }
    
        // Obtener la primera categoría seleccionada
        $this->selectedCategory = count($this->selectedCategories) > 0 ? Category::find($this->selectedCategories[0]) : null;
    
        // Establecer la variable `f` basada en la selección actual
        $this->f = $this->selectedCategory ? $this->selectedCategory->id : null;
    
        // Establecer `isFiltered` a verdadero porque estamos aplicando un filtro
        $this->isFiltered = !is_null($this->f);
        
        // Reiniciar la paginación
        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }
    
    public function filterPrices()
    {
        // Reiniciar a la primera página
        $this->page = 1;
    
        // Limpiar otros filtros
        $this->resetLevel(); 
        $this->resetCategory(); 
    
        // Si selecciona múltiples precios y asegura que se manejen como tal
        if (!is_array($this->selectedPrices)) {
            $this->selectedPrices = ($this->selectedPrices !== '') ? [$this->selectedPrices] : [];
        }
    
        // Obtener el primer precio seleccionado
        $this->selectedPrice = count($this->selectedPrices) > 0 ? Price::find($this->selectedPrices[0]) : null;
    
        // Establecer la variable `p` basada en la selección actual
        $this->p = $this->selectedPrice ? $this->selectedPrice->id : null;
    
        // Establecer `isFiltered` a verdadero porque estamos aplicando un filtro
        $this->isFiltered = !is_null($this->p);
        
        // Reiniciar la paginación
        $this->resetPage();
    }

    public function updatedSelectedPrices()
    {
        $this->resetPage();
    }
}




