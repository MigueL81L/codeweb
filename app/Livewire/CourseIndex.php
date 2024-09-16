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
    public $selectedLevel  = null;
    public $selectedCategory = null;
    
    public function resetLevel()
    {
        $this->selectedLevels = [];
        $this->selectedLevel = null;
    }

    public function resetCategory()
    {
        $this->selectedCategories = [];
        $this->selectedCategory = null;
    }

    public function resetFilters()
    {
        $this->resetLevel();
        $this->resetCategory();
        $this->resetPage(); // Resetea a la primera página de la paginación.
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $mensaje = "";

        // Crear una consulta base
        $coursesQuery = Course::query()->where('status', 3);

        // Filtrar por nivel si está presente
        if ($this->selectedLevel) {
            $coursesQuery->where('level_id', $this->selectedLevel);
        }

        // Filtrar por categoría si está presente
        if ($this->selectedCategory) {
            $coursesQuery->where('category_id', $this->selectedCategory);
        }

        $coursesCount = $coursesQuery->count();
        if ($coursesCount === 0) {
            $mensaje = "No hay cursos disponibles con los filtros actuales.";
        }

        // Obtener cursos paginados
        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
    }

    public function filterLevels()
    {
        $this->resetCategory();

        if (!is_array($this->selectedLevels)) {
            $this->selectedLevels = ($this->selectedLevels !== '') ? [$this->selectedLevels] : [];
        }

        if (!empty($this->selectedLevels)) {
            $this->selectedLevel = $this->selectedLevels[0];
        } else {
            $this->selectedLevel = null;
        }

        $this->resetPage(); // Resetea la paginación tras aplicar filtros nuevos
    }

    public function filterCategories()
    {
        $this->resetLevel();

        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [];
        }

        if (!empty($this->selectedCategories)) {
            $this->selectedCategory = $this->selectedCategories[0];
        } else {
            $this->selectedCategory = null;
        }

        $this->resetPage(); // Resetea la paginación tras aplicar filtros nuevos
    }
}




