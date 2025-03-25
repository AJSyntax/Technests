<?php

namespace App\Livewire;

use App\Models\Portfolio;
use App\Models\Template;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PortfolioBuilder extends Component
{
    use WithFileUploads;

    public $portfolio;
    public $step = 1;
    public $totalSteps = 5;
    
    // Personal Info
    public $name;
    public $title;
    public $bio;
    public $email;
    public $github;
    public $linkedin;
    
    // Skills
    public $skills = [];
    public $newSkill = ['name' => '', 'level' => ''];
    
    // Experience
    public $experiences = [];
    public $newExperience = [
        'title' => '',
        'company' => '',
        'period' => '',
        'description' => ''
    ];
    
    // Projects
    public $projects = [];
    public $newProject = [
        'name' => '',
        'description' => '',
        'github_url' => '',
        'live_url' => '',
        'image' => null
    ];
    
    // Template
    public $selectedTemplate;
    public $templates;

    protected $rules = [
        'name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'bio' => 'required|string',
        'email' => 'required|email',
        'github' => 'nullable|string',
        'linkedin' => 'nullable|url',
        'skills' => 'required|array|min:1',
        'skills.*.name' => 'required|string',
        'skills.*.level' => 'required|integer|min:0|max:100',
        'experiences' => 'required|array|min:1',
        'experiences.*.title' => 'required|string',
        'experiences.*.company' => 'required|string',
        'experiences.*.period' => 'required|string',
        'experiences.*.description' => 'required|string',
        'projects' => 'required|array|min:1',
        'projects.*.name' => 'required|string',
        'projects.*.description' => 'required|string',
        'projects.*.github_url' => 'nullable|url',
        'projects.*.live_url' => 'nullable|url',
        'projects.*.image' => 'nullable|image|max:2048',
        'selectedTemplate' => 'required|exists:templates,id'
    ];

    public function mount($portfolioId = null)
    {
        $this->templates = Template::all();
        
        if ($portfolioId) {
            $this->portfolio = Portfolio::findOrFail($portfolioId);
            $this->loadPortfolioData();
        }
    }

    public function loadPortfolioData()
    {
        $personalInfo = $this->portfolio->personal_info;
        $this->name = $personalInfo['name'] ?? '';
        $this->title = $personalInfo['title'] ?? '';
        $this->bio = $personalInfo['bio'] ?? '';
        $this->email = $personalInfo['email'] ?? '';
        $this->github = $personalInfo['github_username'] ?? '';
        $this->linkedin = $personalInfo['linkedin_url'] ?? '';
        
        $this->skills = $this->portfolio->skills ?? [];
        $this->experiences = $this->portfolio->experience ?? [];
        $this->projects = $this->portfolio->projects ?? [];
        $this->selectedTemplate = $this->portfolio->template_id;
    }

    public function nextStep()
    {
        // Only validate fields relevant to the current step
        if ($this->step === 1) {
            $this->validate([
                'selectedTemplate' => 'required|exists:templates,id',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'bio' => 'required|string',
                'email' => 'required|email',
                'github' => 'nullable|string',
                'linkedin' => 'nullable|url',
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'skills' => 'required|array|min:1',
                'skills.*.name' => 'required|string',
                'skills.*.level' => 'required|integer|min:0|max:100',
            ]);
        } elseif ($this->step === 4) {
            $this->validate([
                'experiences' => 'required|array|min:1',
                'experiences.*.title' => 'required|string',
                'experiences.*.company' => 'required|string',
                'experiences.*.period' => 'required|string',
                'experiences.*.description' => 'required|string',
            ]);
        }
        
        $this->step++;
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function addSkill()
    {
        if (!empty($this->newSkill['name']) && !empty($this->newSkill['level'])) {
            $this->skills[] = $this->newSkill;
            $this->newSkill = ['name' => '', 'level' => ''];
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function addExperience()
    {
        if (!empty($this->newExperience['title']) && !empty($this->newExperience['company'])) {
            $this->experiences[] = $this->newExperience;
            $this->newExperience = [
                'title' => '',
                'company' => '',
                'period' => '',
                'description' => ''
            ];
        }
    }

    public function removeExperience($index)
    {
        unset($this->experiences[$index]);
        $this->experiences = array_values($this->experiences);
    }

    public function addProject()
    {
        if (!empty($this->newProject['name']) && !empty($this->newProject['description'])) {
            $this->projects[] = $this->newProject;
            $this->newProject = [
                'name' => '',
                'description' => '',
                'github_url' => '',
                'live_url' => '',
                'image' => null
            ];
        }
    }

    public function removeProject($index)
    {
        unset($this->projects[$index]);
        $this->projects = array_values($this->projects);
    }

    public function save()
    {
        try {
            $this->validate([
                'selectedTemplate' => 'required|exists:templates,id',
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'bio' => 'required|string',
                'email' => 'required|email',
                'skills' => 'required|array|min:1',
                'experiences' => 'required|array|min:1'
            ]);

            $portfolio = $this->portfolio ?? new Portfolio();
            $portfolio->user_id = auth()->id();
            $portfolio->name = $this->name;
            $portfolio->template_id = $this->selectedTemplate;
            
            // Save personal info
            $portfolio->personal_info = [
                'name' => $this->name,
                'title' => $this->title,
                'bio' => $this->bio,
                'email' => $this->email,
                'github_username' => $this->github,
                'linkedin_url' => $this->linkedin,
            ];

            // Process project images before saving
            $projectsData = $this->projects;
            
            foreach ($projectsData as $index => $project) {
                // Skip if no image or image is already a string URL
                if (!isset($project['image']) || is_string($project['image']) || empty($project['image'])) {
                    if (isset($projectsData[$index]['image']) && !is_string($projectsData[$index]['image'])) {
                        $projectsData[$index]['image'] = null;
                    }
                    continue;
                }
                
                // If image is a Livewire TemporaryUploadedFile
                if (is_object($project['image']) && method_exists($project['image'], 'store')) {
                    try {
                        $path = $project['image']->store('projects', 'public');
                        $projectsData[$index]['image'] = asset('storage/' . $path);
                    } catch (\Exception $e) {
                        // If upload fails, set image to null
                        $projectsData[$index]['image'] = null;
                        session()->flash('warning', 'Failed to upload image for project: ' . $project['name']);
                    }
                } else {
                    // If not a valid upload, set to null
                    $projectsData[$index]['image'] = null;
                }
            }
            
            // Save structured data
            $portfolio->skills = $this->skills;
            $portfolio->experience = $this->experiences;
            $portfolio->projects = $projectsData;

            $saved = $portfolio->save();
            
            if (!$saved) {
                throw new \Exception('Failed to save portfolio.');
            }
            
            session()->flash('message', 'Portfolio saved successfully!');
            return redirect()->route('portfolios.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error, Livewire will handle this automatically
            throw $e;
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Portfolio save error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            session()->flash('error', 'Error saving portfolio: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.portfolio-builder');
    }
} 