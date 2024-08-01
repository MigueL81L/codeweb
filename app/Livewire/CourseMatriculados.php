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

class CourseMatriculados extends Component
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
        $this->w = false;
    }

    public function render()
    {
        $courses = collect(); 
        $filtered = collect();
        $levels = Level::all();
        $categories = Category::all();
        $mensaje = "";

        //Asignación general de la colección de courses matriculados
        $courses = $this->getUserEnrolledCourses();



        //Asignación general de la colección de courses filtrada
        if ($this->a != null && $this->f == null) {
            $filtered = $this->filterLevels();
        } elseif ($this->a == null && $this->f != null) {
            $filtered = $this->filterCategories();
        } else {
            $filtered = collect();
        }



        //Condicionalidad del reseteo
        if ($this->w == false) {
            if($courses->count()!=0){
                $filtered = collect();
                $this->a = null;
                $this->f = null;
                $courses = $this->getUserEnrolledCourses();
                $mensaje="";
            }else{
                $filtered = collect();
                $this->a = null;
                $this->f = null;
                $courses = $this->getUserEnrolledCourses();
                $mensaje="No te has matriculado en ningún curso. A que esperas!";
            }

            $this->w = true;

        } else{
            if($courses->count()!=0){
                if($this->a != null ){
                    $filtered = $this->filterLevels();
                    $courses = $this->getUserEnrolledCourses();
                    $mensaje = "No te has matriculado en cursos de este nivel. A que esperas, tenemos los mejores cursos. Matriculate ya!";
                }elseif($this->f != null){
                    $filtered = $this->filterCategories();
                    $courses = $this->getUserEnrolledCourses();
                    $mensaje = "No te has matriculado en cursos de esta categoría. A que esperas, tenemos los mejores cursos. Matriculate ya!";
                }else{
                    $filtered = collect();
                    $courses = $this->getUserEnrolledCourses();
                    $mensaje="";
                }
            }else{
                $filtered = collect();
                $courses = collect();
                $mensaje="No te has matriculado en ningún curso. A que esperas!";
            }
        }


        $this->c = $filtered->count();
        

        return view('livewire.course-matriculados', compact('levels', 'categories', 'courses', 'mensaje', 'filtered'));
    }

    public function filterLevels()
    {
        // Obtener la colección de cursos matriculados
        $courses = $this->getUserEnrolledCourses();
    
        $this->resetCategory();
    
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
    
        $userId = Auth::id();

        $filteredCourses = Course::whereHas('students', function($query) use ($userId) {
            $query->where('users.id', $userId);
        });
        
        if ($this->a !== null) {
            $filteredCourses->where('level_id', $this->a);
        }
        
        $filteredCourses = $filteredCourses->paginate(8);
    
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
    // Obtener la colección de cursos matriculados
    $courses = $this->getUserEnrolledCourses();

    $this->resetLevel();

    if (!is_array($this->selectedCategories)) {
        $this->selectedCategories = ($this->selectedCategories !== '') ? [$this->selectedCategories] : [];
    }

    foreach ($this->selectedCategories as $category) {
        if ($category != null && $category != '') {
            $categoryID = (int) $category; 
            $chosenCategory = Category::find($categoryID); 
            $this->selectedCategory = $chosenCategory;
            break; 
        }
    }

    if ($this->selectedCategory) {
        $this->f = $this->selectedCategory->id;
    } else {
        $this->f = null;
    }

    $filteredCourses = collect();

    $userId = Auth::id();

    $filteredCourses = Course::whereHas('students', function($query) use ($userId) {
        $query->where('users.id', $userId);
    });
    
    if ($this->f !== null) {
        $filteredCourses->where('category_id', $this->f);
    }
    
    $filteredCourses = $filteredCourses->paginate(8);

    $this->g = count($filteredCourses);
    $this->resetPage();

    return $filteredCourses;
}

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }

    protected function getUserEnrolledCourses()
    {
        $userId = Auth::id();
    
        $enrolledCourses = Course::whereHas('students', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->paginate(8);
    
        return $enrolledCourses;
    }
    
}




