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
    public $selectedCategories = [];
    public $selectedLevels = [];
    public $page; // Navegar a la página 1 antes de la búsqueda




    public function render()
    {
        $categories = Category::all();
        $levels = Level::all();
        $mensaje="mensaje por desarrollar";
    
        $coursesQuery = Course::query();
    
        // Aplicar filtro por categorias si existe alguna seleccionado
        if (!empty($this->selectedCategories)) {
            $coursesQuery->whereHas('categories', function ($query) {
                $query->whereIn('id', $this->selectedCategories);
            });
        }

        // Aplicar filtro por niveles si existe alguno seleccionado
        if (!empty($this->selectedLevels)) {
            $coursesQuery->whereHas('levels', function ($query) {
                $query->whereIn('id', $this->selectedLevels);
            });
        }
    
        $paginatedCourses = $coursesQuery->paginate(8);
    
        return view('livewire.course-index', compact('paginatedCourses', 'categories', 'levels', 'mensaje'));
    }
    

    // Método para manejar el filtrado por roles
    public function filterCoursesCategory()
    {
        // Convertir selectedRoles a array si no lo es
        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = explode(',', $this->selectedCategories);
        }

        // Asegurar que solo se permite un rol seleccionado
        if (count($this->selectedCategories) > 1) {
            session()->flash('warning', 'Por favor, elige solo una categoría para filtrar');
            $this->selectedCategories = [];
            return;
        }

        // Si se selecciona solo un rol, entonces aplica el filtro
        $this->resetPage(); // Reinicia la paginación al aplicar un nuevo filtro
    }

    // Método para manejar el filtrado por roles
    public function filterCoursesLevel()
    {
        // Convertir selectedRoles a array si no lo es
        if (!is_array($this->selectedLevels)) {
            $this->selectedLevels = explode(',', $this->selectedLevels);
        }
    
        // Asegurar que solo se permite un rol seleccionado
        if (count($this->selectedLevels) > 1) {
            session()->flash('warning', 'Por favor, elige solo un nivel para filtrar');
            $this->selectedLevels = [];
            return;
        }
    
        // Si se selecciona solo un rol, entonces aplica el filtro
        $this->resetPage(); // Reinicia la paginación al aplicar un nuevo filtro
    }




    // Método para filtrar usuarios por roles seleccionados
    public function filteredCoursesByCategoriesProperty()
    {
        logger('Roles seleccionados: ' . json_encode($this->selectedCategories));
        
        $filteredCourses = Course::query();

        // Verifica si se ha seleccionado una categoría
        if (!empty($this->selectedCategories)) {
            $filteredCourses = $filteredCourses->whereHas('categories', function ($query) {
                $query->whereIn('id', $this->selectedCategories);
            });
        }

        return $filteredCourses->paginate(8);
    }


    // Método para filtrar usuarios por roles seleccionados
    public function filteredCoursesByLevelsProperty()
    {
        logger('Roles seleccionados: ' . json_encode($this->selectedLevels));
        
        $filteredCourses = Course::query();

        // Verifica si se ha seleccionado una categoría
        if (!empty($this->selectedLevels)) {
            $filteredCourses = $filteredCourses->whereHas('levels', function ($query) {
                $query->whereIn('id', $this->selectedLevels);
            });
        }

        return $filteredCourses->paginate(8);
    }






        
    // Método para manejar actualización de roles seleccionados
    public function updatedSelectedCategories()
    {
        $this->resetPage(); // Reinicia la paginación al actualizar roles seleccionados
    }

    // Método para manejar actualización de roles seleccionados
    public function updatedSelectedLevels()
    {
        $this->resetPage(); // Reinicia la paginación al actualizar roles seleccionados
    }
}








