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

    public $showPagination = true;

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
        $this->gotoPage(1);
        $this->showPagination = true;
    }

    public function filterCategories()
    {
        $this->resetLevel();
        $this->f = $this->selectedCategory ? $this->selectedCategory->id : null;
        $this->gotoPage(1);
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
    
        $coursesQuery = Course::where('status', 3);

        if ($this->a !== null) {
            $coursesQuery->where('level_id', $this->a);
            $this->showPagination = false; // Desactiva paginación
        }

        if ($this->f !== null) {
            $coursesQuery->where('category_id', $this->f);
            $this->showPagination = false; // Desactiva paginación
        }

        $courses = $this->showPagination ? $coursesQuery->latest('id')->paginate(8) : $coursesQuery->get();

        return view('livewire.course-index', [
            'levels' => $levels,
            'categories' => $categories,
            'courses' => $courses,
        ]);
    }
}
