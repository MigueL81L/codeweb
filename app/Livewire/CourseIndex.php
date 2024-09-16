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

    public $selectedLevels = null;
    public $selectedCategories = null;
    public $mensaje = ""; 

    public function resetFilters()
    {
        $this->reset(['selectedLevels', 'selectedCategories']);
        $this->resetPage();
    }

    public function updatedSelectedLevels($value)
    {
        $this->resetCategory();
        $this->resetPage();
    }

    public function updatedSelectedCategories($value)
    {
        $this->resetLevel();
        $this->resetPage();
    }

    public function resetLevel()
    {
        $this->selectedLevels = null;
    }

    public function resetCategory()
    {
        $this->selectedCategories = null;
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $mensaje = "";

        $coursesQuery = Course::query()->where('status', 3);

        if ($this->selectedLevels) {
            $coursesQuery->where('level_id', $this->selectedLevels);
        }

        if ($this->selectedCategories) {
            $coursesQuery->where('category_id', $this->selectedCategories);
        }

        if ($coursesQuery->count() === 0) {
            $mensaje = "No hay cursos que coincidan con estos criterios.";
        }

        $courses = $coursesQuery->latest('id')->paginate(8);

        return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
    }
}






