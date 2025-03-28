<?php

namespace App\Livewire;

use App\Models\Portfolio;
use Livewire\Component;

class PortfolioPreview extends Component
{
    public Portfolio $portfolio;
    public $personalInfo;
    public $skills;
    public $projects;
    public $education;
    public $certifications;

    public function mount(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        $this->loadPortfolioData();
    }

    public function loadPortfolioData()
    {
        $this->personalInfo = $this->portfolio->personalInfo;
        $this->skills = $this->portfolio->skills;
        $this->projects = $this->portfolio->projects;
        $this->education = $this->portfolio->education;
        $this->certifications = $this->portfolio->certifications;
    }

    public function render()
    {
        return view('livewire.portfolio-preview');
    }
} 