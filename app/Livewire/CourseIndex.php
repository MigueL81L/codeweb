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

    public $page;

    public $selectedLevels = [];
    public $selectedLevel = null;
    public $a = null;

    public $selectedCategories = [];
    public $selectedCategory = null;
    public $f = null;

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
    }
    
    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
        $this->f = null;
    }
    
    // Elimina el método resetFilters ya que no se utilizará
    /*
    public function resetFilters()
    {
        $this->resetLevel();
        $this->resetCategory();
        $this->isFiltered = false; 
        $this->page = 1;
        $this->resetPage();
    }
    */

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
    
        $mensaje = "";
    
        // Estado para rehidratar si filtrado.
        $coursesQuery = Course::where('status', 3);
    
        if (!is_null($this->a)) {
            $coursesQuery->whereHas('level', function ($query) {
                $query->where('id', $this->a);
            });
            $this->isFiltered = true;
            if ($coursesQuery->count() === 0) {
                $mensaje = "Todavía no tenemos Cursos de ese Nivel. En breve podrás disponer de los mejores!";
            }
        }
        
        if (!is_null($this->f)) {
            $coursesQuery->whereHas('category', function ($query) {
                $query->where('id', $this->f);
            });
            $this->isFiltered = true;
            if ($coursesQuery->count() === 0) {
                $mensaje = "Todavía no tenemos Cursos de esta Categoría. En breve podrás disponer de los mejores!";
            }
        }
    
        // Decidimos sobre paginar o no dependiendo si está filtrada
        $courses = $this->isFiltered ? $coursesQuery->latest('id')->get() : $coursesQuery->latest('id')->paginate(8)->withQueryString();
    
        return view('livewire.course-index', [
            'levels' => $levels,
            'categories' => $categories,
            'courses' => $courses,
            'mensaje' => $mensaje,
        ]);
    }
    

    public function filterLevels()
    {
        $this->resetCategory();
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
}



