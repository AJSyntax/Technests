<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        Template::create([
            'name' => 'Modern Portfolio',
            'description' => 'A modern, clean portfolio template with a hero section, about me, projects showcase, and contact form. Perfect for developers and creative professionals.',
            'thumbnail_url' => 'templates/modern-portfolio-thumb.jpg',
            'preview_url' => '/templates/modern-portfolio/preview',
            'is_premium' => false,
            'features' => json_encode([
                'Responsive design',
                'Hero section with profile picture',
                'About me section',
                'Projects showcase grid',
                'Contact form',
                'Social media links',
                'Clean and modern UI',
                'Tailwind CSS styling',
            ]),
        ]);

        Template::create([
            'name' => 'IT Programmer Portfolio',
            'description' => 'A modern, elegant template designed specifically for IT professionals and programmers. Features sections for technical skills, project showcases, and professional experience.',
            'thumbnail_url' => 'templates/it-programmer-thumb.jpg',
            'preview_url' => '/templates/it-programmer/preview',
            'is_premium' => false,
            'features' => json_encode([
                'Skill matrix with proficiency levels',
                'GitHub integration',
                'Project showcase with live demos',
                'Technical experience timeline',
                'Code snippet showcase',
                'Dark/Light mode toggle',
                'Responsive design',
                'SEO optimized',
            ]),
        ]);
    }
} 