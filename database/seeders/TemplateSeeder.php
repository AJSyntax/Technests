<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        Template::create([
            'name' => 'IT Programmer Portfolio',
            'description' => 'A modern, elegant template designed specifically for IT professionals and programmers. Features sections for technical skills, project showcases, and professional experience.',
            'thumbnail_path' => 'templates/it-programmer-thumb.jpg',
            'preview_url' => '/templates/it-programmer/preview',
            'is_premium' => false,
            'features' => [
                'Skill matrix with proficiency levels',
                'GitHub integration',
                'Project showcase with live demos',
                'Technical experience timeline',
                'Code snippet showcase',
                'Dark/Light mode toggle',
                'Responsive design',
                'SEO optimized',
            ],
        ]);
    }
} 