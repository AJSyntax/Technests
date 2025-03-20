<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $portfoliosQuery = Portfolio::where('user_id', Auth::id());

        if ($this->search) {
            $portfoliosQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'public') {
            $portfoliosQuery->where('is_public', true);
        } elseif ($this->filter === 'private') {
            $portfoliosQuery->where('is_public', false);
        }

        $portfolios = $portfoliosQuery->latest()->paginate(6);

        return view('livewire.dashboard', [
            'portfolios' => $portfolios,
        ]);
    }

    public function deletePortfolio($id)
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        $portfolio->delete();
        session()->flash('message', 'Portfolio deleted successfully.');
    }
}
