<?php

namespace App\Livewire;

use App\Models\Portfolio;
use App\Models\PersonalInfo;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Education;
use App\Models\Certification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioEditor extends Component
{
    use WithFileUploads;

    public $portfolio;
    public $personalInfo;
    public $skills = [];
    public $projects = [];
    public $education = [];
    public $certifications = [];
    public $newSkill = ['name' => '', 'category' => '', 'description' => ''];
    public $newProject = ['title' => '', 'description' => '', 'github_url' => '', 'technologies' => []];
    public $newEducation = ['institution' => '', 'degree' => '', 'field' => '', 'start_date' => '', 'end_date' => ''];
    public $newCertification = ['name' => '', 'issuer' => '', 'issue_date' => '', 'expiry_date' => '', 'credential_url' => ''];
    public $projectImage;
    public $profilePicture;

    public function mount(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        $this->personalInfo = $portfolio->personalInfo ?? new PersonalInfo();
        $this->skills = $portfolio->skills->toArray();
        $this->projects = $portfolio->projects->toArray();
        $this->education = $portfolio->education->toArray();
        $this->certifications = $portfolio->certifications->toArray();
    }

    public function savePersonalInfo()
    {
        $this->validate([
            'personalInfo.title' => 'required|string|max:255',
            'personalInfo.bio' => 'required|string',
            'personalInfo.contact_info' => 'required|array',
        ]);

        $this->personalInfo->portfolio_id = $this->portfolio->id;
        $this->personalInfo->save();

        if ($this->profilePicture) {
            $path = $this->profilePicture->store('profile-pictures', 'public');
            $this->personalInfo->profile_picture = $path;
            $this->personalInfo->save();
        }

        $this->dispatch('saved');
    }

    public function addSkill()
    {
        $this->validate([
            'newSkill.name' => 'required|string|max:255',
            'newSkill.category' => 'required|string|max:255',
            'newSkill.description' => 'required|string',
        ]);

        $skill = new Skill($this->newSkill);
        $skill->portfolio_id = $this->portfolio->id;
        $skill->save();

        $this->skills[] = $skill->toArray();
        $this->newSkill = ['name' => '', 'category' => '', 'description' => ''];
        $this->dispatch('saved');
    }

    public function removeSkill($index)
    {
        $skill = Skill::find($this->skills[$index]['id']);
        if ($skill) {
            $skill->delete();
            unset($this->skills[$index]);
            $this->skills = array_values($this->skills);
            $this->dispatch('saved');
        }
    }

    public function addProject()
    {
        $this->validate([
            'newProject.title' => 'required|string|max:255',
            'newProject.description' => 'required|string',
            'newProject.github_url' => 'nullable|url',
            'newProject.technologies' => 'required|array',
            'projectImage' => 'nullable|image|max:2048',
        ]);

        $project = new Project($this->newProject);
        $project->portfolio_id = $this->portfolio->id;

        if ($this->projectImage) {
            $path = $this->projectImage->store('project-images', 'public');
            $project->image = $path;
        }

        $project->save();

        $this->projects[] = $project->toArray();
        $this->newProject = ['title' => '', 'description' => '', 'github_url' => '', 'technologies' => []];
        $this->projectImage = null;
        $this->dispatch('saved');
    }

    public function removeProject($index)
    {
        $project = Project::find($this->projects[$index]['id']);
        if ($project) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->delete();
            unset($this->projects[$index]);
            $this->projects = array_values($this->projects);
            $this->dispatch('saved');
        }
    }

    public function addEducation()
    {
        $this->validate([
            'newEducation.institution' => 'required|string|max:255',
            'newEducation.degree' => 'required|string|max:255',
            'newEducation.field' => 'required|string|max:255',
            'newEducation.start_date' => 'required|date',
            'newEducation.end_date' => 'nullable|date|after:newEducation.start_date',
        ]);

        $education = new Education($this->newEducation);
        $education->portfolio_id = $this->portfolio->id;
        $education->save();

        $this->education[] = $education->toArray();
        $this->newEducation = ['institution' => '', 'degree' => '', 'field' => '', 'start_date' => '', 'end_date' => ''];
        $this->dispatch('saved');
    }

    public function removeEducation($index)
    {
        $education = Education::find($this->education[$index]['id']);
        if ($education) {
            $education->delete();
            unset($this->education[$index]);
            $this->education = array_values($this->education);
            $this->dispatch('saved');
        }
    }

    public function addCertification()
    {
        $this->validate([
            'newCertification.name' => 'required|string|max:255',
            'newCertification.issuer' => 'required|string|max:255',
            'newCertification.issue_date' => 'required|date',
            'newCertification.expiry_date' => 'nullable|date|after:newCertification.issue_date',
            'newCertification.credential_url' => 'nullable|url',
        ]);

        $certification = new Certification($this->newCertification);
        $certification->portfolio_id = $this->portfolio->id;
        $certification->save();

        $this->certifications[] = $certification->toArray();
        $this->newCertification = ['name' => '', 'issuer' => '', 'issue_date' => '', 'expiry_date' => '', 'credential_url' => ''];
        $this->dispatch('saved');
    }

    public function removeCertification($index)
    {
        $certification = Certification::find($this->certifications[$index]['id']);
        if ($certification) {
            $certification->delete();
            unset($this->certifications[$index]);
            $this->certifications = array_values($this->certifications);
            $this->dispatch('saved');
        }
    }

    public function render()
    {
        return view('livewire.portfolio-editor');
    }
}
