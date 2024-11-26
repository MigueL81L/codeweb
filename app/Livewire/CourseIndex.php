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

    public $b = null;
    public $c = null;

    public $g = null;

    public $w = true;

    public $isFiltered = false;

    public function resetLevel()
    {
        $this->selectedLevels = [];
        $this->selectedLevel = null;
        $this->a = null; 
        $this->isFiltered = false;         // Indicar que no hay filtros activos
        $this->resetPage(); 
    }
    
    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
        $this->f = null;
        $this->isFiltered = false;         // Indicar que no hay filtros activos
        $this->resetPage(); 
    }
    
    public function resetPrice()
    {
        $this->selectedPrices = [];
        $this->selectedPrice = null;
        $this->p = null;
        $this->isFiltered = false;         // Indicar que no hay filtros activos
        $this->resetPage(); 
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $prices = Price::all(); // Obtener precios

        $mensaje = "";
    
        $coursesQuery = Course::where('status', 3);
    
        // if (!is_null($this->a)) {
        //     $coursesQuery->whereHas('level', function ($query) {
        //         $query->where('id', $this->a);
        //     });
        //     $this->isFiltered = true;
        //     if ($coursesQuery->count() === 0) {
        //         $mensaje = "Todavía no tenemos Cursos de ese Nivel. En breve podrás disponer de los mejores!";
        //     }
        // }
        
        // if (!is_null($this->f)) {
        //     $coursesQuery->whereHas('category', function ($query) {
        //         $query->where('id', $this->f);
        //     });
        //     $this->isFiltered = true;
        //     if ($coursesQuery->count() === 0) {
        //         $mensaje = "Todavía no tenemos Cursos de esta Categoría. En breve podrás disponer de los mejores!";
        //     }
        // }

        // if (!is_null($this->p)) {
        //     $coursesQuery->whereHas('price', function ($query) {
        //         $query->where('id', $this->p);
        //     });
        //     $this->isFiltered = true;
        //     if ($coursesQuery->count() === 0) {
        //         $mensaje = "Todavía no tenemos Cursos en ese Rango de Precios. En breve podrás disponer de los mejores!";
        //     }
        // }
    
        // $courses = $this->isFiltered ? $coursesQuery->latest('id')->get() : $coursesQuery->latest('id')->paginate(8)->withQueryString();

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
        $this->resetCategory();
        $this->resetPrice();
        $this->page = 1;

        if (!is_array($this->selectedLevels)) {
            $this->selectedLevels = ($this->selectedLevels !== '') ? [$this->selectedLevels] : [];
        }

        foreach ($this->selectedLevels as $level) {
            if ($level != null && $level != '') {
                $i = (int) $level; 
                $l = Level::find($i); 
                $this->selectedLevel = $l;
                break;
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

        $this->b = count($filteredCourses);
        $this->resetPage();

        return $filteredCourses; 
    }

    public function updatedSelectedLevels()
    {
        $this->resetPage();
    }

    protected function getFilteredCourses()
    {
        return Course::where('status', 3)
            ->latest('id')
            ->paginate(8);
    }

    public function filterCategories()
    {
        $this->resetLevel();
        $this->resetPrice();
        $this->page = 1;

        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [];
        }

        foreach ($this->selectedCategories as $category) {
            if ($category != null && $category != '') {
                $y = Category::find($category); 
                $this->selectedCategory = $y;
                break;
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
        $this->g = count($filteredCourses);

        $this->resetPage();
        
        return $filteredCourses;
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }
    
    public function filterPrices()
    {
        $this->resetLevel();
        $this->resetCategory();
        $this->page = 1;

        if (!is_array($this->selectedPrices)) {
            $this->selectedPrices = ($this->selectedPrices !== '') ? [$this->selectedPrices] : [];
        }

        foreach ($this->selectedPrices as $price) {
            if ($price != null && $price != '') {
                $z = Price::find($price); 
                $this->selectedPrice = $z;
                break;
            }
        }

        if ($this->selectedPrice) {
            $this->p = $this->selectedPrice->id;
        } else {
            $this->p = null;
        }

        $filteredCourses = collect();

        if ($this->p != null) {
            $filteredCourses = Course::whereHas('price', function ($query) {
                $query->where('id', $this->p);
            })->paginate(8);
        }
        
        $this->resetPage();
        
        return $filteredCourses;
    }

    public function updatedSelectedPrices()
    {
        $this->resetPage();
    }
}




