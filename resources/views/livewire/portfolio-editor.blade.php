<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Personal Information Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
                    <form wire:submit="savePersonalInfo" class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" wire:model="personalInfo.title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                            <textarea wire:model="personalInfo.bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>

                        <div>
                            <label for="profilePicture" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Picture</label>
                            <input type="file" wire:model="profilePicture" id="profilePicture" accept="image/*" class="mt-1 block w-full">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Information</label>
                            <div class="mt-2 space-y-2">
                                <input type="email" wire:model="personalInfo.contact_info.email" placeholder="Email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <input type="tel" wire:model="personalInfo.contact_info.phone" placeholder="Phone" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <input type="text" wire:model="personalInfo.contact_info.location" placeholder="Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Save Personal Info
                        </button>
                    </form>
                </div>

                <!-- Skills Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Skills</h2>
                    <form wire:submit="addSkill" class="space-y-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="skillName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill Name</label>
                                <input type="text" wire:model="newSkill.name" id="skillName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="skillCategory" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <input type="text" wire:model="newSkill.category" id="skillCategory" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="skillDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <input type="text" wire:model="newSkill.description" id="skillDescription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Skill
                        </button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($skills as $index => $skill)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $skill['name'] }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $skill['category'] }}</p>
                                        <p class="mt-2 text-sm">{{ $skill['description'] }}</p>
                                    </div>
                                    <button wire:click="removeSkill({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Projects Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Projects</h2>
                    <form wire:submit="addProject" class="space-y-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="projectTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Title</label>
                                <input type="text" wire:model="newProject.title" id="projectTitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="projectGithubUrl" class="block text-sm font-medium text-gray-700 dark:text-gray-300">GitHub URL</label>
                                <input type="url" wire:model="newProject.github_url" id="projectGithubUrl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label for="projectDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea wire:model="newProject.description" id="projectDescription" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label for="projectImage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Image</label>
                            <input type="file" wire:model="projectImage" id="projectImage" accept="image/*" class="mt-1 block w-full">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Project
                        </button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($projects as $index => $project)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                @if(isset($project['image']))
                                    <img src="{{ Storage::url($project['image']) }}" alt="{{ $project['title'] }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                @endif
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $project['title'] }}</h3>
                                        <p class="mt-2 text-sm">{{ $project['description'] }}</p>
                                        @if($project['github_url'])
                                            <a href="{{ $project['github_url'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">View on GitHub →</a>
                                        @endif
                                    </div>
                                    <button wire:click="removeProject({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Education Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Education</h2>
                    <form wire:submit="addEducation" class="space-y-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="institution" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution</label>
                                <input type="text" wire:model="newEducation.institution" id="institution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="degree" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Degree</label>
                                <input type="text" wire:model="newEducation.degree" id="degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="field" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Field of Study</label>
                                <input type="text" wire:model="newEducation.field" id="field" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" wire:model="newEducation.start_date" id="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                            <input type="date" wire:model="newEducation.end_date" id="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Education
                        </button>
                    </form>

                    <div class="space-y-4">
                        @foreach($education as $index => $edu)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $edu['institution'] }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $edu['degree'] }} in {{ $edu['field'] }}</p>
                                        <p class="text-sm mt-2">{{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}</p>
                                    </div>
                                    <button wire:click="removeEducation({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Certifications Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Certifications</h2>
                    <form wire:submit="addCertification" class="space-y-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="certName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Certification Name</label>
                                <input type="text" wire:model="newCertification.name" id="certName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="issuer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Issuer</label>
                                <input type="text" wire:model="newCertification.issuer" id="issuer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="issueDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Issue Date</label>
                                <input type="date" wire:model="newCertification.issue_date" id="issueDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="expiryDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                                <input type="date" wire:model="newCertification.expiry_date" id="expiryDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label for="credentialUrl" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credential URL</label>
                            <input type="url" wire:model="newCertification.credential_url" id="credentialUrl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Certification
                        </button>
                    </form>

                    <div class="space-y-4">
                        @foreach($certifications as $index => $cert)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $cert['name'] }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cert['issuer'] }}</p>
                                        <p class="text-sm mt-2">Issued: {{ $cert['issue_date'] }}</p>
                                        @if($cert['expiry_date'])
                                            <p class="text-sm">Expires: {{ $cert['expiry_date'] }}</p>
                                        @endif
                                        @if($cert['credential_url'])
                                            <a href="{{ $cert['credential_url'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">View Credential →</a>
                                        @endif
                                    </div>
                                    <button wire:click="removeCertification({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
