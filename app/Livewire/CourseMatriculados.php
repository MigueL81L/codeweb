<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use App\Models\Price;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CourseMatriculados extends Component
{
    use WithPagination;

    public $selectedLevels = [];
    public $selectedLevel = null;
    public $a = null;

    public $selectedCategories = [];
    public $selectedCategory = null;
    public $f = null;

    public $selectedPrices = [];
    public $selectedPrice = null;
    public $p = null;

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
    
    public function resetPrice()
    {
        $this->selectedPrices = [];
        $this->selectedPrice = null;
        $this->p = null;
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $prices = Price::all();

        $mensaje = "";
    
        $coursesQuery = Course::whereHas('students', function($query) {
            $query->where('users.id', Auth::id());
        });
    
        if (!is_null($this->a)) {
            $coursesQuery->whereHas('level', function ($query) {
                $query->where('id', $this->a);
            });
            $this->isFiltered = true;
            if ($coursesQuery->count() === 0) {
                $mensaje = "No te has matriculado en cursos de este nivel.";
            }
        }
        
        if (!is_null($this->f)) {
            $coursesQuery->whereHas('category', function ($query) {
                $query->where('id', $this->f);
            });
            $this->isFiltered = true;
            if ($coursesQuery->count() === 0) {
                $mensaje = "No te has matriculado en cursos de esta categoría.";
            }
        }

        if (!is_null($this->p)) {
            $coursesQuery->whereHas('price', function ($query) {
                $query->where('id', $this->p);
            });
            $this->isFiltered = true;
            if ($coursesQuery->count() === 0) {
                $mensaje = "No te has matriculado en cursos en este rango de precios.";
            }
        }
    
        $courses = $this->isFiltered ? $coursesQuery->latest('id')->get() : $coursesQuery->latest('id')->paginate(8)->withQueryString();
    
        return view('livewire.course-matriculados', compact('levels', 'categories', 'prices', 'courses', 'mensaje'));
    }
    
    public function filterLevels()
    {
        $this->resetCategory();
        $this->resetPrice();

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
        $this->resetPrice();

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
    
    public function filterPrices()
    {
        $this->resetLevel();
        $this->resetCategory();

        if (!is_array($this->selectedPrices)) {
            $this->selectedPrices = ($this->selectedPrices !== '') ? [$this->selectedPrices] : [];
        }

        foreach ($this->selectedPrices as $price) {
            if ($price != null && $price != '') {
                $this->selectedPrice = Price::find((int)$price);
                break;
            }
        }

        $this->p = $this->selectedPrice ? $this->selectedPrice->id : null;
        $this->resetPage();
    }

    public function updatedSelectedPrices()
    {
        $this->resetPage();
    }
}






