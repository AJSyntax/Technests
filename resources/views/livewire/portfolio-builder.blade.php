<div class="max-w-4xl mx-auto py-8 px-4" x-data="{}">
    <form wire:submit.prevent="save">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">{{ $portfolio ? 'Edit Portfolio' : 'Create Portfolio' }}</h1>
                <div class="flex space-x-4">
                    <button type="button" wire:click="previousStep" @if($step === 1) disabled @endif
                        class="px-4 py-2 bg-gray-200 rounded-md {{ $step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300' }}">
                        Previous
                    </button>
                    @if($step < 5)
                        <button type="button" wire:click="nextStep"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Next
                        </button>
                    @else
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Save Portfolio
                        </button>
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($step / 5) * 100 }}%"></div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Step 1: Template Selection -->
        @if($step === 1)
            <div>
                <h2 class="text-2xl font-semibold mb-4">Choose a Template</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templates as $template)
                        <div wire:click="$set('selectedTemplate', {{ $template->id }})"
                            class="border rounded-lg p-4 cursor-pointer {{ $selectedTemplate == $template->id ? 'border-blue-500 ring-2 ring-blue-500' : 'hover:border-gray-400' }}">
                            <img src="{{ asset($template->thumbnail_url) }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-lg font-semibold">{{ $template->name }}</h3>
                            <p class="text-gray-600">{{ $template->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 2: Personal Information -->
        @if($step === 2)
            <div>
                <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Portfolio Name</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Professional Title</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea wire:model="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">GitHub Username</label>
                        <input type="text" wire:model="github" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('github') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                        <input type="url" wire:model="linkedin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('linkedin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 3: Skills -->
        @if($step === 3)
            <div>
                <h2 class="text-2xl font-semibold mb-4">Skills</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" wire:model="newSkill.name" placeholder="Skill name" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="flex-1">
                            <input type="number" wire:model="newSkill.level" placeholder="Proficiency (0-100)" 
                                class="w-full rounded-md border-gray-300 shadow-sm" min="0" max="100">
                        </div>
                        <button wire:click="addSkill" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Skill
                        </button>
                    </div>

                    <div class="space-y-2">
                        @foreach($skills as $index => $skill)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-md">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $skill['name'] }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $skill['level'] }}%"></div>
                                    </div>
                                </div>
                                <button wire:click="removeSkill({{ $index }})" 
                                    class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 4: Experience -->
        @if($step === 4)
            <div>
                <h2 class="text-2xl font-semibold mb-4">Experience</h2>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <div>
                            <input type="text" wire:model="newExperience.title" placeholder="Job Title" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <input type="text" wire:model="newExperience.company" placeholder="Company" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <input type="text" wire:model="newExperience.period" placeholder="Period (e.g., 2020 - Present)" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <textarea wire:model="newExperience.description" placeholder="Job Description" 
                                class="w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                        </div>
                        <button wire:click="addExperience" 
                            class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Experience
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach($experiences as $index => $experience)
                            <div class="p-4 bg-gray-50 rounded-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $experience['title'] }}</h3>
                                        <p class="text-gray-600">{{ $experience['company'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $experience['period'] }}</p>
                                        <p class="mt-2">{{ $experience['description'] }}</p>
                                    </div>
                                    <button wire:click="removeExperience({{ $index }})" 
                                        class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 5: Projects -->
        @if($step === 5)
            <div>
                <h2 class="text-2xl font-semibold mb-4">Projects</h2>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <div>
                            <input type="text" wire:model="newProject.name" placeholder="Project Name" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <textarea wire:model="newProject.description" placeholder="Project Description" 
                                class="w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                        </div>
                        <div>
                            <input type="url" wire:model="newProject.github_url" placeholder="GitHub URL" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <input type="url" wire:model="newProject.live_url" placeholder="Live Demo URL" 
                                class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Image</label>
                            <input type="file" wire:model="newProject.image" 
                                class="mt-1 block w-full" accept="image/*">
                        </div>
                        <button wire:click="addProject" 
                            class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Project
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($projects as $index => $project)
                            <div class="p-4 bg-gray-50 rounded-md">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        @if(isset($project['image']))
                                            <img src="{{ $project['image'] }}" alt="{{ $project['name'] }}" 
                                                class="w-full h-40 object-cover rounded-md mb-2">
                                        @endif
                                        <h3 class="font-semibold">{{ $project['name'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $project['description'] }}</p>
                                        <div class="mt-2 space-x-2">
                                            @if(!empty($project['github_url']))
                                                <a href="{{ $project['github_url'] }}" target="_blank" 
                                                    class="text-blue-500 hover:text-blue-700">GitHub</a>
                                            @endif
                                            @if(!empty($project['live_url']))
                                                <a href="{{ $project['live_url'] }}" target="_blank" 
                                                    class="text-blue-500 hover:text-blue-700">Live Demo</a>
                                            @endif
                                        </div>
                                    </div>
                                    <button wire:click="removeProject({{ $index }})" 
                                        class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </form>
</div> 