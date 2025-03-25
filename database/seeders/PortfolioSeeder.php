<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a demo user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Get the modern portfolio template
        $template = Template::where('slug', 'modern-portfolio')->first();

        if (!$template) {
            return;
        }

        // Create a demo portfolio
        Portfolio::create([
            'user_id' => $user->id,
            'template_id' => $template->id,
            'name' => 'My Professional Portfolio',
            'personal_info' => [
                'name' => 'John Doe',
                'title' => 'Full Stack Developer',
                'bio' => 'Passionate full-stack developer with 5+ years of experience in building modern web applications. Specialized in Laravel, Vue.js, and React.',
                'email' => 'john.doe@example.com',
                'github_username' => 'johndoe',
                'linkedin_url' => 'https://linkedin.com/in/johndoe',
            ],
            'skills' => [
                [
                    'name' => 'Laravel',
                    'level' => 90,
                ],
                [
                    'name' => 'Vue.js',
                    'level' => 85,
                ],
                [
                    'name' => 'React',
                    'level' => 80,
                ],
                [
                    'name' => 'PHP',
                    'level' => 95,
                ],
                [
                    'name' => 'JavaScript',
                    'level' => 90,
                ],
                [
                    'name' => 'MySQL',
                    'level' => 85,
                ],
            ],
            'experience' => [
                [
                    'title' => 'Senior Full Stack Developer',
                    'company' => 'Tech Solutions Inc.',
                    'period' => '2020 - Present',
                    'description' => 'Leading a team of developers in building enterprise-level web applications using Laravel and Vue.js. Implemented CI/CD pipelines and improved application performance by 40%.',
                ],
                [
                    'title' => 'Full Stack Developer',
                    'company' => 'Web Innovators',
                    'period' => '2018 - 2020',
                    'description' => 'Developed and maintained multiple client projects using Laravel, React, and Node.js. Collaborated with designers to implement responsive and accessible user interfaces.',
                ],
                [
                    'title' => 'Junior Developer',
                    'company' => 'Digital Agency',
                    'period' => '2016 - 2018',
                    'description' => 'Started as a junior developer working on various PHP and JavaScript projects. Gained experience in modern web development practices and agile methodologies.',
                ],
            ],
            'projects' => [
                [
                    'name' => 'E-commerce Platform',
                    'description' => 'A full-featured e-commerce platform built with Laravel and Vue.js. Includes features like product management, cart functionality, payment integration, and order tracking.',
                    'github_url' => 'https://github.com/johndoe/ecommerce-platform',
                    'live_url' => 'https://demo-ecommerce.example.com',
                    'image' => null,
                ],
                [
                    'name' => 'Task Management System',
                    'description' => 'A collaborative task management system with real-time updates using Laravel, React, and WebSockets. Features include task assignment, progress tracking, and team collaboration.',
                    'github_url' => 'https://github.com/johndoe/task-manager',
                    'live_url' => 'https://demo-tasks.example.com',
                    'image' => null,
                ],
                [
                    'name' => 'Portfolio Builder',
                    'description' => 'A web application that allows users to create and manage their professional portfolios. Built with Laravel and Alpine.js.',
                    'github_url' => 'https://github.com/johndoe/portfolio-builder',
                    'live_url' => 'https://demo-portfolio.example.com',
                    'image' => null,
                ],
            ],
        ]);
    }
} 