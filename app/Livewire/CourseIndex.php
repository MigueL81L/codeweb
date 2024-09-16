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
    public $mensaje = "";

    public function resetFilters()
    {
        $this->selectedLevels = [];
        $this->selectedCategories = [];
        $this->resetPage();
    }

    public function updatedSelectedLevels()
    {
        $this->resetPage(); 
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $levels = Level::all();
        $categories = Category::all();
        $mensaje="";

        // Crear la consulta de cursos
        $coursesQuery = Course::query()->where('status', 3);

        // Filtrar por niveles seleccionados
        if (!empty($this->selectedLevels)) {
            $coursesQuery->whereIn('level_id', $this->selectedLevels);
        }

        // Filtrar por categorías seleccionadas
        if (!empty($this->selectedCategories)) {
            $coursesQuery->whereIn('category_id', $this->selectedCategories);
        }

        // Paginación
        $courses = $coursesQuery->latest('id')->paginate(8);
        
        // Manejo de mensajes si no hay cursos
        if ($courses->isEmpty()) {
            $this->mensaje = "No hay cursos que coincidan con los criterios de filtrado.";
        } else {
            $this->mensaje = ""; 
        }

        // Retornar la vista con las variables necesarias
        return view('livewire.course-index', compact('levels', 'categories', 'courses', 'mensaje'));
    }
}








