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
    public $selectedCategories = [];
    public $selectedCategory = null;
    public $a = null;  // Used for level filtering
    public $f = null;  // Used for category filtering
    public $mensaje = ""; // Message for empty state

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
        $this->resetPage();
    }

    public function updatedSelectedLevels()
    {
        $this->resetCategory();
        $this->resetPage();
        if ($this->selectedLevels) {
            $this->a = (int) $this->selectedLevels;
            if($this->a){
                $this->mensaje = "";
            }
        } else {
            $this->a = null;
        }
    }

    public function updatedSelectedCategories()
    {
        $this->resetLevel();
        $this->resetPage();
        if ($this->selectedCategories) {
            $this->f = (int) $this->selectedCategories;
            if($this->f){
                $this->mensaje = "";
            }
        } else {
            $this->f = null;
        }
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();

        $coursesQuery = Course::query()->where('status', 3);

        if ($this->a) {
            $coursesQuery->whereHas('level', function ($query) {
                $query->where('id', $this->a);
            });

            if ($coursesQuery->count() === 0) {
                $this->mensaje = "Todavía no tenemos Cursos de ese Nivel. En breve podrás disponer de los mejores!";
            }
        }

        if ($this->f) {
            $coursesQuery->whereHas('category', function ($query) {
                $query->where('id', $this->f);
            });

            if ($coursesQuery->count() === 0) {
                $this->mensaje = "Todavía no tenemos Cursos de esta Categoría. En breve podrás disponer de los mejores!";
            }
        }

        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
    }
}





