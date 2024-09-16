<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CourseMatriculados extends Component
{
    use WithPagination;

    public $selectedLevels = [];
    public $selectedCategories = [];
    public $selectedLevel = null;
    public $selectedCategory = null;
    public $a = null;
    public $f = null;

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
        $this->resetPage();  // Resetea a la primera página de la paginación.
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $mensaje = "";

        // Construimos la consulta de cursos que el usuario está matriculado
        $coursesQuery = Course::whereHas('students', function($query) {
            $query->where('users.id', Auth::id());
        });

        if (!is_null($this->a)) {
            $coursesQuery->where('level_id', $this->a);
            $mensaje = "No te has matriculado en cursos de este nivel. ¡A que esperas, tenemos los mejores cursos! ¡Matriculate ya!";
        }

        if (!is_null($this->f)) {
            $coursesQuery->where('category_id', $this->f);
            $mensaje = "No te has matriculado en cursos de esta categoría. ¡A que esperas, tenemos los mejores cursos! ¡Matriculate ya!";
        }

        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-matriculados', compact('levels', 'categories', 'courses', 'mensaje'));
    }

    public function filterLevels()
    {
        $this->resetCategory();

        if (!is_array($this->selectedLevels)) {
            $this->selectedLevels = ($this->selectedLevels !== '') ? [$this->selectedLevels] : [];
        }

        foreach ($this->selectedLevels as $level) {
            if ($level != null && $level != '') {
                $this->selectedLevel = Level::find((int)$level);
                break;
            }
        }

        $this->a = $this->selectedLevel ? $this->selectedLevel->id : null;
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
            $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [];
        }

        foreach ($this->selectedCategories as $category) {
            if ($category != null && $category != '') {
                $this->selectedCategory = Category::find((int)$category);
                break;
            }
        }

        $this->f = $this->selectedCategory ? $this->selectedCategory->id : null;
        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }
}





