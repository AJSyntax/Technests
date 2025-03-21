<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class TemplatePreviewController extends Controller
{
    public function show($templateSlug)
    {
        // Get the template or fail
        $template = Template::where('preview_url', '/templates/' . $templateSlug . '/preview')->firstOrFail();

        // Create a sample portfolio data object
        $portfolio = new stdClass();
        $portfolio->name = "Jane Doe";
        $portfolio->title = "Full Stack Developer | DevOps Engineer | Open Source Contributor";
        $portfolio->bio = "Passionate software engineer with 5+ years of experience building scalable web applications and microservices. Specializing in Laravel, React, and AWS cloud architecture.";
        $portfolio->profile_picture_url = "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400";
        $portfolio->github_username = "janedoe";
        $portfolio->linkedin_url = "https://linkedin.com/in/janedoe";
        $portfolio->website = "https://janedoe.dev";

        // Sample skills grouped by category
        $portfolio->skills = collect([
            $this->createSkill("Backend Development", "PHP/Laravel", 95),
            $this->createSkill("Backend Development", "Node.js", 85),
            $this->createSkill("Backend Development", "Python/Django", 80),
            $this->createSkill("Frontend Development", "React", 90),
            $this->createSkill("Frontend Development", "Vue.js", 85),
            $this->createSkill("Frontend Development", "TypeScript", 88),
            $this->createSkill("DevOps & Cloud", "Docker", 92),
            $this->createSkill("DevOps & Cloud", "AWS", 85),
            $this->createSkill("DevOps & Cloud", "CI/CD", 90),
            $this->createSkill("Database", "MySQL", 90),
            $this->createSkill("Database", "MongoDB", 85),
            $this->createSkill("Database", "Redis", 80),
        ]);

        // Sample projects
        $portfolio->projects = collect([
            $this->createProject(
                "Cloud Task Manager",
                "A scalable task management system built with Laravel and Vue.js, featuring real-time updates and team collaboration.",
                ["Laravel", "Vue.js", "Redis", "AWS"],
                "https://github.com/janedoe/cloud-task-manager",
                "https://taskmanager.demo.com",
                "/img/projects/task-manager.jpg"
            ),
            $this->createProject(
                "DevOps Dashboard",
                "Centralized dashboard for monitoring multiple CI/CD pipelines, server health, and deployment status.",
                ["React", "Node.js", "Docker", "GraphQL"],
                "https://github.com/janedoe/devops-dashboard",
                "https://devops-dashboard.demo.com",
                "/img/projects/devops-dashboard.jpg"
            ),
            $this->createProject(
                "API Gateway Service",
                "Microservice-based API gateway with rate limiting, caching, and authentication.",
                ["Go", "gRPC", "Redis", "Kubernetes"],
                "https://github.com/janedoe/api-gateway",
                null,
                "/img/projects/api-gateway.jpg"
            ),
        ]);

        // Sample work experience
        $portfolio->experiences = collect([
            $this->createExperience(
                "Senior Full Stack Developer",
                "TechCorp Solutions",
                "Led a team of 5 developers in building and maintaining cloud-native applications using Laravel and React.",
                Carbon::parse('2021-01-01'),
                null,
                true,
                "San Francisco, CA"
            ),
            $this->createExperience(
                "DevOps Engineer",
                "Cloud Systems Inc",
                "Implemented CI/CD pipelines and managed cloud infrastructure for 20+ microservices.",
                Carbon::parse('2019-03-01'),
                Carbon::parse('2020-12-31'),
                false,
                "Seattle, WA"
            ),
            $this->createExperience(
                "Software Engineer",
                "WebDev Studios",
                "Developed and maintained multiple client projects using Laravel, Vue.js, and AWS services.",
                Carbon::parse('2017-06-01'),
                Carbon::parse('2019-02-28'),
                false,
                "Portland, OR"
            ),
        ]);

        // Return the template view with sample data
        return view('templates.it-programmer.show', compact('portfolio'));
    }

    private function createSkill($category, $name, $proficiency_level)
    {
        $skill = new stdClass();
        $skill->category = $category;
        $skill->name = $name;
        $skill->proficiency_level = $proficiency_level;
        return $skill;
    }

    private function createProject($name, $description, $technologies, $github_url, $live_url, $image_path)
    {
        $project = new stdClass();
        $project->name = $name;
        $project->description = $description;
        $project->technologies_used = $technologies;
        $project->github_url = $github_url;
        $project->live_url = $live_url;
        $project->image_path = $image_path;
        $project->is_featured = true;
        return $project;
    }

    private function createExperience($position, $company, $description, $start_date, $end_date, $is_current, $location)
    {
        $experience = new stdClass();
        $experience->position = $position;
        $experience->company = $company;
        $experience->description = $description;
        $experience->start_date = $start_date;
        $experience->end_date = $end_date;
        $experience->is_current = $is_current;
        $experience->location = $location;
        return $experience;
    }
} 