<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $personalInfo->title }} - Portfolio</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white dark:bg-gray-800 shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $personalInfo->title }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">About</a>
                    <a href="#skills" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Skills</a>
                    <a href="#projects" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Projects</a>
                    <a href="#education" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Education</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="about" class="pt-20 pb-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        {{ $personalInfo->title }}
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {{ $personalInfo->bio }}
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 md:justify-start">
                        @if($personalInfo->contact_info['email'])
                            <a href="mailto:{{ $personalInfo->contact_info['email'] }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Contact Me
                            </a>
                        @endif
                    </div>
                </div>
                @if($personalInfo->profile_picture)
                    <div class="mt-8 md:mt-0 md:ml-8">
                        <img src="assets/images/profile-picture.jpg" alt="Profile Picture" class="h-48 w-48 rounded-full object-cover shadow-lg">
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    @if($skills->count() > 0)
        <section id="skills" class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Skills</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Technical Expertise
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($skills as $skill)
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $skill->name }}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $skill->category }}</p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $skill->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Projects Section -->
    @if($projects->count() > 0)
        <section id="projects" class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Projects</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Featured Work
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        @foreach($projects as $project)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                                @if($project->image)
                                    <img src="assets/images/project-{{ $project->id }}.jpg" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            View on GitHub
                                            <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Education Section -->
    @if($education->count() > 0)
        <section id="education" class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Education</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Academic Background
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-8">
                        @foreach($education as $edu)
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $edu->institution }}</h3>
                                <p class="mt-1 text-lg text-gray-600 dark:text-gray-300">{{ $edu->degree }} in {{ $edu->field }}</p>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">{{ $edu->start_date }} - {{ $edu->end_date ?? 'Present' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Contact</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Get in Touch
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @if($personalInfo->contact_info['email'])
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Email</h3>
                            <a href="mailto:{{ $personalInfo->contact_info['email'] }}" class="mt-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $personalInfo->contact_info['email'] }}
                            </a>
                        </div>
                    @endif

                    @if($personalInfo->contact_info['phone'])
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Phone</h3>
                            <a href="tel:{{ $personalInfo->contact_info['phone'] }}" class="mt-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $personalInfo->contact_info['phone'] }}
                            </a>
                        </div>
                    @endif

                    @if($personalInfo->contact_info['location'])
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Location</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ $personalInfo->contact_info['location'] }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} {{ $personalInfo->title }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 