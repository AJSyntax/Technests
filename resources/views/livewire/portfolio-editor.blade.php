<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form wire:submit.prevent="save" class="p-6">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
                        <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly on your portfolio.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Portfolio Name</label>
                            <div class="mt-1">
                                <input type="text" wire:model="portfolio.name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Professional Title</label>
                            <div class="mt-1">
                                <input type="text" wire:model="portfolio.title" id="title" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <div class="mt-1">
                                <textarea wire:model="portfolio.bio" id="bio" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            @error('portfolio.bio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mt-10 space-y-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>
                        <p class="mt-1 text-sm text-gray-500">How can people reach you?</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input type="email" wire:model="portfolio.contact_email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.contact_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <div class="mt-1">
                                <input type="text" wire:model="portfolio.phone" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <div class="mt-1">
                                <input type="text" wire:model="portfolio.location" id="location" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <div class="mt-1">
                                <input type="url" wire:model="portfolio.website" id="website" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="github" class="block text-sm font-medium text-gray-700">GitHub Username</label>
                            <div class="mt-1">
                                <input type="text" wire:model="portfolio.github_username" id="github" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.github_username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                            <div class="mt-1">
                                <input type="url" wire:model="portfolio.linkedin_url" id="linkedin" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('portfolio.linkedin_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="mt-10 space-y-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Skills & Expertise</h2>
                        <p class="mt-1 text-sm text-gray-500">Add your technical skills and proficiency levels.</p>
                    </div>

                    <!-- Existing Skills -->
                    <div class="space-y-4">
                        @foreach($skills as $index => $skill)
                            <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-md">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $skill['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $skill['category'] }} • Level {{ $skill['proficiency_level'] }}/5</p>
                                </div>
                                <button type="button" wire:click="removeSkill({{ $index }})" class="text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Skill -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Skill</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="skill-name" class="block text-sm font-medium text-gray-700">Skill Name</label>
                                <div class="mt-1">
                                    <input type="text" wire:model="newSkill.name" id="skill-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="skill-category" class="block text-sm font-medium text-gray-700">Category</label>
                                <div class="mt-1">
                                    <input type="text" wire:model="newSkill.category" id="skill-category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="skill-level" class="block text-sm font-medium text-gray-700">Proficiency Level</label>
                                <div class="mt-1">
                                    <select wire:model="newSkill.proficiency_level" id="skill-level" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="skill-years" class="block text-sm font-medium text-gray-700">Years Experience</label>
                                <div class="mt-1">
                                    <input type="number" wire:model="newSkill.years_experience" id="skill-years" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 invisible">Add</label>
                                <div class="mt-1">
                                    <button type="button" wire:click="addSkill" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Skill
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects -->
                <div class="mt-10 space-y-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Projects</h2>
                        <p class="mt-1 text-sm text-gray-500">Showcase your best work.</p>
                    </div>

                    <!-- Existing Projects -->
                    <div class="space-y-4">
                        @foreach($projects as $index => $project)
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $project['name'] }}</h3>
                                    <button type="button" wire:click="removeProject({{ $index }})" class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-gray-600">{{ $project['description'] }}</p>
                                @if(is_array($project['technologies_used']))
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach($project['technologies_used'] as $tech)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Project -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Project</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="project-name" class="block text-sm font-medium text-gray-700">Project Name</label>
                                <div class="mt-1">
                                    <input type="text" wire:model="newProject.name" id="project-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="project-description" class="block text-sm font-medium text-gray-700">Description</label>
                                <div class="mt-1">
                                    <textarea wire:model="newProject.description" id="project-description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="project-github" class="block text-sm font-medium text-gray-700">GitHub URL</label>
                                <div class="mt-1">
                                    <input type="url" wire:model="newProject.github_url" id="project-github" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="project-live" class="block text-sm font-medium text-gray-700">Live URL</label>
                                <div class="mt-1">
                                    <input type="url" wire:model="newProject.live_url" id="project-live" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="project-tech" class="block text-sm font-medium text-gray-700">Technologies Used</label>
                                <div class="mt-1">
                                    <input type="text" wire:model="newProject.technologies_used" id="project-tech" placeholder="Comma-separated list" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="project-start" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <div class="mt-1">
                                    <input type="date" wire:model="newProject.start_date" id="project-start" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="project-end" class="block text-sm font-medium text-gray-700">End Date</label>
                                <div class="mt-1">
                                    <input type="date" wire:model="newProject.end_date" id="project-end" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="newProject.is_featured" id="project-featured" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="project-featured" class="font-medium text-gray-700">Featured Project</label>
                                        <p class="text-gray-500">This project will be highlighted in your portfolio.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <button type="button" wire:click="addProject" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visibility -->
                <div class="mt-10">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" wire:model="portfolio.is_public" id="is_public" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_public" class="font-medium text-gray-700">Make Portfolio Public</label>
                            <p class="text-gray-500">Your portfolio will be accessible to anyone with the link.</p>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="mt-10 flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Portfolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
