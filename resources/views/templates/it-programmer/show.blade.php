<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->name }} - IT Professional Portfolio</title>
    <meta name="description" content="{{ $portfolio->bio }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600&family=Inter:wght@400;500;600;700&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style>
        [x-cloak] { display: none !important; }
        .skill-bar { @apply h-2 rounded-full bg-indigo-600 transition-all duration-500; }
        .project-card:hover .project-overlay { @apply opacity-100; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ darkMode: false }" :class="{ 'dark bg-gray-900': darkMode }">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $portfolio->name }}
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
                    <a href="#skills" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Skills</a>
                    <a href="#projects" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Projects</a>
                    <a href="#experience" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Experience</a>
                    <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 bg-gradient-to-br from-indigo-50 to-white dark:from-gray-800 dark:to-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Hi, I'm <span class="text-indigo-600 dark:text-indigo-400">{{ $portfolio->name }}</span>
                    </h1>
                    <div class="text-xl sm:text-2xl text-gray-600 dark:text-gray-300 mb-8">
                        <span id="typed-output"></span>
                    </div>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">{{ $portfolio->bio }}</p>
                    <div class="flex space-x-4">
                        @if($portfolio->github_username)
                            <a href="https://github.com/{{ $portfolio->github_username }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                GitHub Profile
                            </a>
                        @endif
                        @if($portfolio->linkedin_url)
                            <a href="{{ $portfolio->linkedin_url }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                LinkedIn Profile
                            </a>
                        @endif
                    </div>
                </div>
                <div class="relative">
                    @if($portfolio->profile_picture_url)
                        <div class="relative w-64 h-64 mx-auto">
                            <div class="absolute inset-0 bg-indigo-600 rounded-full opacity-10 blur-2xl"></div>
                            <img src="{{ $portfolio->profile_picture_url }}" alt="{{ $portfolio->name }}" class="relative w-64 h-64 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 px-4 bg-white dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12">Technical Skills</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($portfolio->skills->groupBy('category') as $category => $skills)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ $category }}</h3>
                        <div class="space-y-4">
                            @foreach($skills as $skill)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $skill->proficiency_level }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="skill-bar" style="width: {{ $skill->proficiency_level }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 px-4 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12">Featured Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolio->projects->where('is_featured', true) as $project)
                    <div class="project-card group relative bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                        @if($project->image_path)
                            <img src="{{ $project->image_path }}" alt="{{ $project->name }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $project->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $project->description }}</p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($project->technologies_used as $tech)
                                    <span class="px-2 py-1 text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <div class="flex space-x-4">
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                @endif
                                @if($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-20 px-4 bg-white dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12">Professional Experience</h2>
            <div class="relative">
                <div class="absolute left-1/2 transform -translate-x-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                <div class="space-y-12">
                    @foreach($portfolio->experiences as $experience)
                        <div class="relative">
                            <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-4">
                                <div class="w-8 h-8 rounded-full border-4 border-white dark:border-gray-800 bg-indigo-600"></div>
                            </div>
                            <div class="ml-12 lg:ml-0 lg:w-1/2 {{ $loop->iteration % 2 == 0 ? 'lg:ml-auto' : 'lg:mr-auto' }} bg-white dark:bg-gray-700 rounded-lg p-6 shadow-md">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $experience->position }}</h3>
                                <div class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">{{ $experience->company }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                    · {{ $experience->location }}
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">{{ $experience->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-4 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex justify-center space-x-6 mb-6">
                @if($portfolio->github_username)
                    <a href="https://github.com/{{ $portfolio->github_username }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                @endif
                @if($portfolio->linkedin_url)
                    <a href="{{ $portfolio->linkedin_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                @endif
                @if($portfolio->website)
                    <a href="{{ $portfolio->website }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </a>
                @endif
            </div>
            <p class="text-gray-600 dark:text-gray-400">© {{ date('Y') }} {{ $portfolio->name }}. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Typed('#typed-output', {
                strings: ['{{ $portfolio->title }}'],
                typeSpeed: 50,
                backSpeed: 30,
                backDelay: 3000,
                loop: true
            });
        });
    </script>
</body>
</html> 