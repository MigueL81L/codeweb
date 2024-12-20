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
    
        $usersQuery = User::query();
        
        // Aplicar filtro por búsqueda si existe
        if (!empty($this->search)) {
            $usersQuery = $usersQuery->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            });
        }
    
        // Aplicar filtro por roles si existe alguno seleccionado
        if (!empty($this->selectedRoles)) {
            $usersQuery->whereHas('roles', function ($query) {
                $query->whereIn('id', $this->selectedRoles);
            });
        }
    
        $paginatedUsers = $usersQuery->paginate(5);
    
        return view('livewire.admin-users', compact('paginatedUsers', 'roles'));
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

    // Método para el botón Reset del filtrado por roles
     public function resetRoles()
    {
        // Solo limpiar la selección de roles si estaba filtrada
        if (!empty($this->selectedRoles)) {
            $this->selectedRoles = [];
            // Redirigir al usuario a la vista de índice
            return redirect()->route('admin.users.index'); // Cambia esto si es necesario
        }
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
            ->paginate(5);
    }

    public function updatedSearch()
    {
        $this->resetPage();
        logger('Propiedad search actualizada: ' . $this->search);
    }


        


    // Método para filtrar usuarios por roles seleccionados
    public function filteredUsersByRolesProperty()
    {
        logger('Roles seleccionados: ' . json_encode($this->selectedRoles));
        
        $filteredUsers = User::query();

        // Verifica si se ha seleccionado un rol
        if (!empty($this->selectedRoles)) {
            $filteredUsers = $filteredUsers->whereHas('roles', function ($query) {
                $query->whereIn('id', $this->selectedRoles);
            });
        }

        return $filteredUsers->paginate(5);
    }



        
    // Método para manejar actualización de roles seleccionados
    public function updatedSelectedRoles()
    {
        $this->resetPage(); // Reinicia la paginación al actualizar roles seleccionados
    }
}











