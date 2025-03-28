<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        // Free Templates
        Template::create([
            'name' => 'Modern Minimal',
            'description' => 'A clean and modern portfolio template with a minimalist design.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Modern+Minimal',
            'price' => 0,
            'is_premium' => false,
        ]);

        Template::create([
            'name' => 'Professional Dark',
            'description' => 'A professional dark-themed portfolio template perfect for developers.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Professional+Dark',
            'price' => 0,
            'is_premium' => false,
        ]);

        Template::create([
            'name' => 'Creative Light',
            'description' => 'A creative portfolio template with a light and airy design.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Creative+Light',
            'price' => 0,
            'is_premium' => false,
        ]);

        // Premium Templates
        Template::create([
            'name' => 'Premium Developer',
            'description' => 'A premium portfolio template specifically designed for software developers.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Premium+Developer',
            'price' => 29.99,
            'is_premium' => true,
        ]);

        Template::create([
            'name' => 'Creative Pro',
            'description' => 'A premium creative portfolio template with advanced features.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Creative+Pro',
            'price' => 39.99,
            'is_premium' => true,
        ]);

        Template::create([
            'name' => 'Business Elite',
            'description' => 'A premium business portfolio template for professionals.',
            'thumbnail_url' => 'https://via.placeholder.com/800x600?text=Business+Elite',
            'price' => 49.99,
            'is_premium' => true,
        ]);
    }
} 