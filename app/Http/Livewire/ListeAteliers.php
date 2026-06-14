<?php

namespace App\Http\Livewire;

use App\Models\Atelier;
use App\Models\Campus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class ListeAteliers extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $search = '';
    public $date = '';
    public $campus = '';

    protected $rules = [
        'search' => 'nullable|string',
        'campus' => 'nullable|exists:campuses,id',
        'date' => 'nullable|date',
    ];

    protected $listeners = [
        'refreshParent' => '$refresh',
        'showEmitedFlashMessage',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDate()
    {
        $this->resetPage();
    }

    public function updatingCampus()
    {
        $this->resetPage();
    }

    public function showEmitedFlashMessage($message, $etiquette)
    {
        session()->flash($etiquette, $message);
    }

    public function render()
    {
        return view('livewire.ateliers-liste', [
            'liste_campus' => Campus::all(),
            'ateliers' => Atelier::with('animateurs')
                ->orderBy('debut_atelier', 'asc')
                ->when(strlen($this->search) >= 3, function ($query) {
                    return $query->where(function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%')
                            ->orWhereHas('animateurs', function ($q) {
                                $q->where('nom', 'like', '%' . $this->search . '%')
                                    ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                    ->orWhere('biographie', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->when($this->campus, function ($query) {
                    return $query->where('campus_id', $this->campus);
                })
                ->when($this->date, function ($query) {
                    return $query->whereDate('date', $this->date);
                })
                ->paginate(10),
        ]);
    }
}
