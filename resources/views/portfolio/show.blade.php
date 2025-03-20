<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $portfolio->name }} - Portfolio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Portfolio Content -->
        <div class="bg-white shadow-sm">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-16">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl font-bold mb-4">{{ $portfolio->title }}</h1>
                    <p class="text-xl opacity-90">{{ $portfolio->bio }}</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="border-b">
                <div class="max-w-4xl mx-auto px-8 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @if($portfolio->contact_email)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                <p class="mt-1 text-gray-900">{{ $portfolio->contact_email }}</p>
                            </div>
                        @endif
                        @if($portfolio->location)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Location</h3>
                                <p class="mt-1 text-gray-900">{{ $portfolio->location }}</p>
                            </div>
                        @endif
                        @if($portfolio->website)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Website</h3>
                                <a href="{{ $portfolio->website }}" target="_blank" class="mt-1 text-indigo-600 hover:text-indigo-900">Visit Website</a>
                            </div>
                        @endif
                        @if($portfolio->github_username)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">GitHub</h3>
                                <a href="https://github.com/{{ $portfolio->github_username }}" target="_blank" class="mt-1 text-indigo-600 hover:text-indigo-900">@{{ $portfolio->github_username }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            @if($portfolio->skills->isNotEmpty())
                <div class="border-b">
                    <div class="max-w-4xl mx-auto px-8 py-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-8">Skills & Expertise</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($portfolio->skills->groupBy('category') as $category => $skills)
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-4">{{ $category ?? 'Other' }}</h3>
                                    <ul class="space-y-3">
                                        @foreach($skills as $skill)
                                            <li class="flex items-center justify-between">
                                                <span class="text-gray-700">{{ $skill->name }}</span>
                                                @if($skill->proficiency_level)
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <div class="w-2 h-2 rounded-full ml-1 {{ $i <= $skill->proficiency_level ? 'bg-indigo-500' : 'bg-gray-200' }}"></div>
                                                        @endfor
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Projects Section -->
            @if($portfolio->projects->isNotEmpty())
                <div class="max-w-4xl mx-auto px-8 py-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Featured Projects</h2>
                    <div class="grid grid-cols-1 gap-8">
                        @foreach($portfolio->projects as $project)
                            <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $project->name }}</h3>
                                        <div class="flex space-x-4">
                                            @if($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" class="text-gray-600 hover:text-gray-900">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($project->live_url)
                                                <a href="{{ $project->live_url }}" target="_blank" class="text-gray-600 hover:text-gray-900">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4">{{ $project->description }}</p>
                                    @if($project->technologies_used)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($project->technologies_used as $tech)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div class="border-t">
                <div class="max-w-4xl mx-auto px-8 py-4">
                    <p class="text-center text-sm text-gray-500">
                        Built with <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900">TechNest</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 