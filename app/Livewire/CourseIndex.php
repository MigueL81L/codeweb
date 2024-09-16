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
    public $selectedCategories = [];
    public $a = null;
    public $f = null;

    public function resetLevel()
    {
        $this->selectedLevels = [];
        $this->a = null;
    }

    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->f = null;
    }

    public function resetFilters()
    {
        $this->resetLevel();
        $this->resetCategory();
        $this->resetPage();
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $mensaje = "";

        $coursesQuery = Course::query()->where('status', 3);

        if (!empty($this->a)) {
            $coursesQuery->where('level_id', $this->a);
        }

        if (!empty($this->f)) {
            $coursesQuery->where('category_id', $this->f);
        }

        if ($coursesQuery->count() === 0) {
            $mensaje = "No hay cursos disponibles con los filtros actuales.";
        }

        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
    }

    public function filterLevels()
    {
        $this->resetCategory();

        if (!is_array($this->selectedLevels)) {
            $this->selectedLevels = $this->selectedLevels ? [$this->selectedLevels] : [];
        }

        if (!empty($this->selectedLevels)) {
            $this->a = (int)$this->selectedLevels[0];
        }

        $this->resetPage();
    }

    public function updatedSelectedLevels()
    {
        $this->resetPage();
    }

    public function filterCategories()
    {
        $this->resetLevel();

        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = $this->selectedCategories ? [$this->selectedCategories] : [];
        }

        if (!empty($this->selectedCategories)) {
            $this->f = (int)$this->selectedCategories[0];
        }

        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }
}



