<?php



namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AdminUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRoles = [];
    public $page; // Navegar a la página 1 antes de la búsqueda

    public function render()
    {
        if (Gate::denies('Leer usuarios')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        $allUsers = User::paginate(10);
        $filteredUsersBySearch = $this->filteredUsersBySearchProperty();
        $filteredUsersByRoles = $this->filteredUsersByRolesProperty();

        return view('livewire.admin-users', compact('allUsers', 'filteredUsersBySearch', 'filteredUsersByRoles', 'roles'));
    }

    // Método para manejar el filtrado por roles
    public function filterUsers()
    {
        // Convertir selectedRoles a array si no lo es
        if (!is_array($this->selectedRoles)) {
            $this->selectedRoles = explode(',', $this->selectedRoles);
        }

        // Asegurar que solo se permite un rol seleccionado
        if (count($this->selectedRoles) > 1) {
            session()->flash('warning', 'Por favor, elige solo un rol para filtrar');
            $this->selectedRoles = [];
            return;
        }

        // Si se selecciona solo un rol, entonces aplica el filtro
        $this->resetPage(); // Reinicia la paginación al aplicar un nuevo filtro
    }


    // Método para filtrar usuarios por búsqueda
    public function filteredUsersBySearchProperty()
    {
        logger('Propiedad search actualizada: ' . $this->search);
        $pageContainingUser = 1; 

        if ($pageContainingUser !== $this->page) {
            $this->gotoPage($pageContainingUser);
        }

        return User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function updatedSearch()
    {
        logger('Propiedad search actualizada: ' . $this->search);
    }


        


    // Método para filtrar usuarios por roles seleccionados
    public function filteredUsersByRolesProperty()
    {
        $filteredUsers = User::query();

        // Verifica si se ha seleccionado un rol
        if (!empty($this->selectedRoles)) {
            $filteredUsers = $filteredUsers->whereHas('roles', function ($query) {
                $query->whereIn('id', $this->selectedRoles);
            });
        }

        return $filteredUsers->paginate(10);
    }



        
    // Método para manejar actualización de roles seleccionados
    public function updatedSelectedRoles()
    {
        $this->resetPage(); // Reinicia la paginación al actualizar roles seleccionados
    }
}











