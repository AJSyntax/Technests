<?php

namespace App\Livewire;

use App\Models\Portfolio;
use App\Models\Template;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioEditor extends Component
{
    use WithFileUploads;

    public Portfolio $portfolio;
    public $skills = [];
    public $newSkill = [
        'name' => '',
        'category' => '',
        'proficiency_level' => 3,
        'years_experience' => null,
        'description' => '',
    ];
    public $projects = [];
    public $newProject = [
        'name' => '',
        'description' => '',
        'github_url' => '',
        'live_url' => '',
        'technologies_used' => '',
        'start_date' => '',
        'end_date' => '',
        'is_featured' => false,
    ];

    protected $rules = [
        'portfolio.name' => 'required|min:3',
        'portfolio.title' => 'required|min:3',
        'portfolio.bio' => 'required|min:10',
        'portfolio.contact_email' => 'required|email',
        'portfolio.phone' => 'nullable|string',
        'portfolio.location' => 'nullable|string',
        'portfolio.website' => 'nullable|url',
        'portfolio.github_username' => 'nullable|string',
        'portfolio.linkedin_url' => 'nullable|url',
        'portfolio.is_public' => 'boolean',
    ];

    public function mount($portfolio = null)
    {
        if ($portfolio) {
            if ($portfolio->user_id !== Auth::id()) {
                abort(403);
            }
            $this->portfolio = $portfolio;
            $this->skills = $portfolio->skills->toArray();
            $this->projects = $portfolio->projects->toArray();
        } else {
            $this->portfolio = new Portfolio([
                'user_id' => Auth::id(),
                'is_public' => true,
            ]);
        }
    }

    public function addSkill()
    {
        $this->validate([
            'newSkill.name' => 'required|string|min:2',
            'newSkill.category' => 'required|string|min:2',
            'newSkill.proficiency_level' => 'required|integer|min:1|max:5',
        ]);

        $this->skills[] = $this->newSkill;
        $this->newSkill = [
            'name' => '',
            'category' => '',
            'proficiency_level' => 3,
            'years_experience' => null,
            'description' => '',
        ];
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function addProject()
    {
        $this->validate([
            'newProject.name' => 'required|string|min:2',
            'newProject.description' => 'required|string|min:10',
            'newProject.github_url' => 'nullable|url',
            'newProject.live_url' => 'nullable|url',
        ]);

        $this->projects[] = array_merge($this->newProject, [
            'technologies_used' => explode(',', $this->newProject['technologies_used']),
        ]);

        $this->newProject = [
            'name' => '',
            'description' => '',
            'github_url' => '',
            'live_url' => '',
            'technologies_used' => '',
            'start_date' => '',
            'end_date' => '',
            'is_featured' => false,
        ];
    }

    public function removeProject($index)
    {
        unset($this->projects[$index]);
        $this->projects = array_values($this->projects);
    }

    public function save()
    {
        $this->validate();

        $this->portfolio->save();

        // Save skills
        $this->portfolio->skills()->delete();
        foreach ($this->skills as $skill) {
            $this->portfolio->skills()->create($skill);
        }

        // Save projects
        $this->portfolio->projects()->delete();
        foreach ($this->projects as $index => $project) {
            $this->portfolio->projects()->create(array_merge($project, [
                'display_order' => $index,
            ]));
        }

        session()->flash('message', 'Portfolio saved successfully.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.portfolio-editor', [
            'templates' => Template::all(),
        ]);
    }
}
