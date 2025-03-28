<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
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
                            <div class="rounded-md shadow">
                                <a href="mailto:{{ $personalInfo->contact_info['email'] }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Contact Me
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if($personalInfo->profile_picture)
                    <div class="mt-8 md:mt-0 md:ml-8">
                        <img src="{{ Storage::url($personalInfo->profile_picture) }}" alt="Profile Picture" class="h-48 w-48 rounded-full object-cover">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Skills Section -->
    @if($skills->count() > 0)
        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Skills</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Technical Expertise
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($skills as $skill)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $skill->name }}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $skill->category }}</p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $skill->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Projects Section -->
    @if($projects->count() > 0)
        <div class="py-12 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Projects</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Featured Work
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        @foreach($projects as $project)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                                @if($project->image)
                                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
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
        </div>
    @endif

    <!-- Education Section -->
    @if($education->count() > 0)
        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Education</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Academic Background
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-8">
                        @foreach($education as $edu)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $edu->institution }}</h3>
                                <p class="mt-1 text-lg text-gray-600 dark:text-gray-300">{{ $edu->degree }} in {{ $edu->field }}</p>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">{{ $edu->start_date }} - {{ $edu->end_date ?? 'Present' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Certifications Section -->
    @if($certifications->count() > 0)
        <div class="py-12 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Certifications</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Professional Certifications
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        @foreach($certifications as $cert)
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $cert->name }}</h3>
                                <p class="mt-1 text-lg text-gray-600 dark:text-gray-300">{{ $cert->issuer }}</p>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">Issued: {{ $cert->issue_date }}</p>
                                @if($cert->expiry_date)
                                    <p class="text-gray-500 dark:text-gray-400">Expires: {{ $cert->expiry_date }}</p>
                                @endif
                                @if($cert->credential_url)
                                    <a href="{{ $cert->credential_url }}" target="_blank" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        View Credential
                                        <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Contact Section -->
    <div class="py-12 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Contact</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Get in Touch
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @if($personalInfo->contact_info['email'])
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Email</h3>
                            <a href="mailto:{{ $personalInfo->contact_info['email'] }}" class="mt-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $personalInfo->contact_info['email'] }}
                            </a>
                        </div>
                    @endif

                    @if($personalInfo->contact_info['phone'])
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Phone</h3>
                            <a href="tel:{{ $personalInfo->contact_info['phone'] }}" class="mt-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $personalInfo->contact_info['phone'] }}
                            </a>
                        </div>
                    @endif

                    @if($personalInfo->contact_info['location'])
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Location</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ $personalInfo->contact_info['location'] }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 