<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        $results = $this->results; // Usar la propiedad computada directamente
        return view('livewire.search', compact('results'));
    }

    // Propiedad Computada: get+Nombre+Property
    public function getResultsProperty()
    {
        logger('getResultsProperty ejecutado: ' . $this->search);
        return Course::where('title', 'LIKE', '%' . $this->search . '%')
            ->where('status', 3)
            ->take(8)
            ->get();
    }

    public function updatedSearch()
    {
        logger('Propiedad search actualizada: ' . $this->search);
    }
}


