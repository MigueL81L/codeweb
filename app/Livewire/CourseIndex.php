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

    // Propiedades para filtrado
    public $selectedLevels = [];
    public $selectedCategories = [];
    public $selectedLevel = null;
    public $selectedCategory = null;
    public $a = null;   // ID de nivel seleccionado
    public $f = null;   // ID de categoría seleccionado

    public function resetLevel() {
        $this->selectedLevels = [];
        $this->selectedLevel = null;
        $this->a = null;
    }

    public function resetCategory() {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
        $this->f = null;
    }

    public function resetFilters() {
        $this->resetLevel();
        $this->resetCategory();
        $this->gotoPage(1);
    }

    public function render() {
        $levels = Level::all();
        $categories = Category::all();

        $mensaje = "";

        $coursesQuery = Course::where('status', 3);

        if ($this->a !== null) {
            $coursesQuery->whereHas('level', function ($query) {
                $query->where('id', $this->a);
            });

            if ($coursesQuery->count() === 0) {
                $mensaje = "Todavía no tenemos Cursos de ese Nivel. En breve podrás disponer de los mejores!";
            }
        }

        if ($this->f !== null) {
            $coursesQuery->whereHas('category', function ($query) {
                $query->where('id', $this->f);
            });

            if ($coursesQuery->count() === 0) {
                $mensaje = "Todavía no tenemos Cursos de esta Categoría. En breve podrás disponer de los mejores!";
            }
        }

        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', [
            'levels' => $levels,
            'categories' => $categories,
            'courses' => $courses,
            'mensaje' => $mensaje,
        ]);
    }
}
