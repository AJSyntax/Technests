<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $portfolio->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('portfolios.edit', $portfolio) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Portfolio
                </a>
                <a href="{{ route('portfolios.preview', $portfolio) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Preview
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="mt-1">{{ $portfolio->personal_info['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Professional Title</p>
                                <p class="mt-1">{{ $portfolio->personal_info['title'] }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Bio</p>
                                <p class="mt-1">{{ $portfolio->personal_info['bio'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1">{{ $portfolio->personal_info['email'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">GitHub</p>
                                <p class="mt-1">
                                    @if(!empty($portfolio->personal_info['github_username']))
                                        <a href="https://github.com/{{ $portfolio->personal_info['github_username'] }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ $portfolio->personal_info['github_username'] }}
                                        </a>
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">LinkedIn</p>
                                <p class="mt-1">
                                    @if(!empty($portfolio->personal_info['linkedin_url']))
                                        <a href="{{ $portfolio->personal_info['linkedin_url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            View Profile
                                        </a>
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Skills</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($portfolio->skills as $skill)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900">{{ $skill['name'] }}</h4>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $skill['level'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No skills added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Experience</h3>
                        <div class="space-y-6">
                            @forelse($portfolio->experience as $experience)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="font-medium text-gray-900">{{ $experience['title'] }}</h4>
                                    <p class="text-gray-600">{{ $experience['company'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $experience['period'] }}</p>
                                    <p class="mt-2">{{ $experience['description'] }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">No experience added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Projects</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($portfolio->projects as $project)
                                <div class="bg-gray-50 rounded-lg overflow-hidden">
                                    @if(!empty($project['image']))
                                        <img src="{{ $project['image'] }}" alt="{{ $project['name'] }}" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-6">
                                        <h4 class="font-medium text-gray-900">{{ $project['name'] }}</h4>
                                        <p class="mt-2 text-gray-600">{{ $project['description'] }}</p>
                                        <div class="mt-4 flex space-x-4">
                                            @if(!empty($project['github_url']))
                                                <a href="{{ $project['github_url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    View on GitHub
                                                </a>
                                            @endif
                                            @if(!empty($project['live_url']))
                                                <a href="{{ $project['live_url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    Live Demo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No projects added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Template Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Template Information</h3>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($portfolio->template->thumbnail) }}" alt="{{ $portfolio->template->name }}" class="w-24 h-24 object-cover rounded-lg">
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-medium text-gray-900">{{ $portfolio->template->name }}</h4>
                                    <p class="mt-1 text-gray-600">{{ $portfolio->template->description }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('public.portfolios.show', $portfolio) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            View Public Page
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 