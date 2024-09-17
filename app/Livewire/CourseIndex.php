<?php  

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Livewire\WithPagination;

class CourseIndex extends Component
{
    use WithPagination;

    public $selectedLevels = [];
    public $selectedLevel = null;
    public $a = null;

    public $selectedCategories = [];
    public $selectedCategory = null;
    public $f = null;

    public $filtrada = false;

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

    public function resetFilters()
    {
        $this->resetLevel();
        $this->resetCategory();
        $this->filtrada = false;  // Asegúrate de resetear la bandera de filtrado.
        $this->resetPage();       // Resetear paginación.
    }

    public function filterLevels()
    {
        $this->resetCategory();
        $this->filtrada = true;   // Cuando se aplica un filtro, marcamos como filtrada.
        $this->a = $this->selectedLevel ? $this->selectedLevel->id : null;
        $this->resetPage();       // Reiniciar paginación cuando se aplica filtro.
    }

    public function filterCategories()
    {
        $this->resetLevel();
        $this->filtrada = true;   // Cuando se aplica un filtro, marcamos como filtrada.
        $this->f = $this->selectedCategory ? $this->selectedCategory->id : null;
        $this->resetPage();       // Reiniciar paginación cuando se aplica filtro.
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        
        $coursesQuery = Course::where('status', 3);

        if (!is_null($this->a)) {
            $coursesQuery->where('level_id', $this->a);
        }

        if (!is_null($this->f)) {
            $coursesQuery->where('category_id', $this->f);
        }

        // Aplicar paginación solo si no está filtrada
        $courses = $this->filtrada ? $coursesQuery->latest('id')->get() : $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', [
            'levels' => $levels,
            'categories' => $categories,
            'courses' => $courses,
            'mensaje' => $mensaje ?? '',
        ]);
    }
}
