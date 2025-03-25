<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'template_id' => Template::factory(),
            'name' => $this->faker->words(3, true),
            'personal_info' => [
                'name' => $this->faker->name(),
                'title' => $this->faker->jobTitle(),
                'bio' => $this->faker->paragraph(),
                'email' => $this->faker->email(),
                'github_username' => $this->faker->userName(),
                'linkedin_url' => $this->faker->url(),
            ],
            'skills' => [
                [
                    'name' => 'PHP',
                    'level' => $this->faker->numberBetween(60, 100),
                ],
                [
                    'name' => 'JavaScript',
                    'level' => $this->faker->numberBetween(60, 100),
                ],
                [
                    'name' => 'Laravel',
                    'level' => $this->faker->numberBetween(60, 100),
                ],
            ],
            'experience' => [
                [
                    'title' => $this->faker->jobTitle(),
                    'company' => $this->faker->company(),
                    'period' => $this->faker->date('Y') . ' - Present',
                    'description' => $this->faker->paragraph(),
                ],
                [
                    'title' => $this->faker->jobTitle(),
                    'company' => $this->faker->company(),
                    'period' => $this->faker->date('Y') . ' - ' . $this->faker->date('Y'),
                    'description' => $this->faker->paragraph(),
                ],
            ],
            'projects' => [
                [
                    'name' => $this->faker->words(3, true),
                    'description' => $this->faker->paragraph(),
                    'github_url' => 'https://github.com/' . $this->faker->userName() . '/' . $this->faker->slug(),
                    'live_url' => $this->faker->url(),
                ],
                [
                    'name' => $this->faker->words(3, true),
                    'description' => $this->faker->paragraph(),
                    'github_url' => 'https://github.com/' . $this->faker->userName() . '/' . $this->faker->slug(),
                    'live_url' => $this->faker->url(),
                ],
            ],
        ];
    }
} 