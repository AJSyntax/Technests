<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Template;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@technest.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create some templates
        $templates = [
            [
                'name' => 'Modern Minimalist',
                'description' => 'A clean and minimalist template perfect for developers.',
                'thumbnail_url' => '/templates/modern-minimalist.jpg',
                'is_premium' => false,
                'price' => 0,
                'html_template' => $this->getModernMinimalistHtml(),
                'css_template' => $this->getModernMinimalistCss(),
            ],
            [
                'name' => 'Professional Dark',
                'description' => 'A professional dark theme template with accent colors.',
                'thumbnail_url' => '/templates/professional-dark.jpg',
                'is_premium' => true,
                'price' => 29.99,
                'html_template' => $this->getProfessionalDarkHtml(),
                'css_template' => $this->getProfessionalDarkCss(),
            ],
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }

        // Run the portfolio seeder
        $this->call(PortfolioSeeder::class);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            TemplateSeeder::class,
        ]);
    }

    private function getModernMinimalistHtml(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->personal_info['name'] }} - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <header class="py-20 text-center">
        <h1 class="text-4xl font-bold text-gray-900">{{ $portfolio->personal_info['name'] }}</h1>
        <p class="mt-4 text-xl text-gray-600">{{ $portfolio->personal_info['title'] }}</p>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section class="mb-16">
            <h2 class="text-2xl font-bold mb-6">About Me</h2>
            <p class="text-gray-700">{{ $portfolio->personal_info['bio'] }}</p>
        </section>

        <section class="mb-16">
            <h2 class="text-2xl font-bold mb-6">Skills</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($portfolio->skills as $skill)
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold">{{ $skill['name'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $skill['level'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-2xl font-bold mb-6">Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($portfolio->projects as $project)
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">{{ $project['name'] }}</h3>
                    <p class="text-gray-600 mb-4">{{ $project['description'] }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="mr-4">{{ $project['language'] }}</span>
                        <a href="{{ $project['url'] }}" target="_blank" class="text-blue-500 hover:text-blue-600">View Project →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-2xl font-bold mb-6">Experience</h2>
            <div class="space-y-8">
                @foreach($portfolio->experience as $exp)
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold">{{ $exp['title'] }}</h3>
                    <p class="text-gray-600">{{ $exp['company'] }} • {{ $exp['period'] }}</p>
                    <p class="mt-4 text-gray-700">{{ $exp['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold mb-6">Contact</h2>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="mb-4">
                    <strong>Email:</strong> 
                    <a href="mailto:{{ $portfolio->personal_info['email'] }}" class="text-blue-500">
                        {{ $portfolio->personal_info['email'] }}
                    </a>
                </p>
                @if(isset($portfolio->personal_info['linkedin']))
                <p class="mb-4">
                    <strong>LinkedIn:</strong>
                    <a href="{{ $portfolio->personal_info['linkedin'] }}" target="_blank" class="text-blue-500">
                        {{ $portfolio->personal_info['linkedin'] }}
                    </a>
                </p>
                @endif
                @if(isset($portfolio->personal_info['github']))
                <p>
                    <strong>GitHub:</strong>
                    <a href="https://github.com/{{ $portfolio->personal_info['github'] }}" target="_blank" class="text-blue-500">
                        {{ $portfolio->personal_info['github'] }}
                    </a>
                </p>
                @endif
            </div>
        </section>
    </main>

    <footer class="text-center py-8 text-gray-500">
        <p>© {{ date('Y') }} {{ $portfolio->personal_info['name'] }}. All rights reserved.</p>
    </footer>
</body>
</html>
HTML;
    }

    private function getModernMinimalistCss(): string
    {
        return <<<'CSS'
/* Custom styles for Modern Minimalist template */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.container {
    max-width: 1200px;
}

/* Smooth transitions */
a {
    transition: all 0.2s ease-in-out;
}

/* Hover effects */
.bg-white {
    transition: transform 0.2s ease-in-out;
}

.bg-white:hover {
    transform: translateY(-2px);
}
CSS;
    }

    private function getProfessionalDarkHtml(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->personal_info['name'] }} - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">
    <header class="py-20 text-center">
        <h1 class="text-5xl font-bold text-purple-400">{{ $portfolio->personal_info['name'] }}</h1>
        <p class="mt-4 text-xl text-gray-400">{{ $portfolio->personal_info['title'] }}</p>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section class="mb-20">
            <h2 class="text-3xl font-bold mb-8 text-purple-400">About Me</h2>
            <p class="text-gray-300 text-lg leading-relaxed">{{ $portfolio->personal_info['bio'] }}</p>
        </section>

        <section class="mb-20">
            <h2 class="text-3xl font-bold mb-8 text-purple-400">Skills</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($portfolio->skills as $skill)
                <div class="bg-gray-800 p-6 rounded-lg border border-purple-500/20">
                    <h3 class="font-semibold text-xl text-purple-300">{{ $skill['name'] }}</h3>
                    <p class="text-gray-400 mt-2">{{ $skill['level'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="text-3xl font-bold mb-8 text-purple-400">Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($portfolio->projects as $project)
                <div class="bg-gray-800 p-8 rounded-lg border border-purple-500/20">
                    <h3 class="text-2xl font-semibold mb-4 text-purple-300">{{ $project['name'] }}</h3>
                    <p class="text-gray-300 mb-6">{{ $project['description'] }}</p>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-400 mr-6">{{ $project['language'] }}</span>
                        <a href="{{ $project['url'] }}" target="_blank" class="text-purple-400 hover:text-purple-300">
                            View Project →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="text-3xl font-bold mb-8 text-purple-400">Experience</h2>
            <div class="space-y-8">
                @foreach($portfolio->experience as $exp)
                <div class="bg-gray-800 p-8 rounded-lg border border-purple-500/20">
                    <h3 class="text-2xl font-semibold text-purple-300">{{ $exp['title'] }}</h3>
                    <p class="text-gray-400 mt-2">{{ $exp['company'] }} • {{ $exp['period'] }}</p>
                    <p class="mt-6 text-gray-300">{{ $exp['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-3xl font-bold mb-8 text-purple-400">Contact</h2>
            <div class="bg-gray-800 p-8 rounded-lg border border-purple-500/20">
                <p class="mb-6">
                    <strong class="text-purple-300">Email:</strong> 
                    <a href="mailto:{{ $portfolio->personal_info['email'] }}" class="text-gray-300 hover:text-purple-400">
                        {{ $portfolio->personal_info['email'] }}
                    </a>
                </p>
                @if(isset($portfolio->personal_info['linkedin']))
                <p class="mb-6">
                    <strong class="text-purple-300">LinkedIn:</strong>
                    <a href="{{ $portfolio->personal_info['linkedin'] }}" target="_blank" class="text-gray-300 hover:text-purple-400">
                        {{ $portfolio->personal_info['linkedin'] }}
                    </a>
                </p>
                @endif
                @if(isset($portfolio->personal_info['github']))
                <p>
                    <strong class="text-purple-300">GitHub:</strong>
                    <a href="https://github.com/{{ $portfolio->personal_info['github'] }}" target="_blank" class="text-gray-300 hover:text-purple-400">
                        {{ $portfolio->personal_info['github'] }}
                    </a>
                </p>
                @endif
            </div>
        </section>
    </main>

    <footer class="text-center py-12 text-gray-500">
        <p>© {{ date('Y') }} {{ $portfolio->personal_info['name'] }}. All rights reserved.</p>
    </footer>
</body>
</html>
HTML;
    }

    private function getProfessionalDarkCss(): string
    {
        return <<<'CSS'
/* Custom styles for Professional Dark template */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.container {
    max-width: 1200px;
}

/* Smooth transitions */
a {
    transition: all 0.2s ease-in-out;
}

/* Hover effects */
.bg-gray-800 {
    transition: transform 0.2s ease-in-out, border-color 0.2s ease-in-out;
}

.bg-gray-800:hover {
    transform: translateY(-2px);
    border-color: rgba(168, 85, 247, 0.4);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: #1f2937;
}

::-webkit-scrollbar-thumb {
    background: #4c1d95;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #6d28d9;
}
CSS;
    }
}
