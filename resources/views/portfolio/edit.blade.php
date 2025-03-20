<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Portfolio - {{ config('app.name', 'TechNest') }}</title>
    <meta name="description" content="Edit your portfolio details, experiences, education, and more.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('portfolio.index')" :active="request()->routeIs('portfolio.*')">
                                {{ __('Portfolios') }}
                            </x-nav-link>
                            <x-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">
                                {{ __('Templates') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="md:flex md:items-center md:justify-between mb-6">
                        <div class="min-w-0 flex-1">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                Edit Portfolio: {{ $portfolio->name }}
                            </h2>
                        </div>
                        <div class="mt-4 flex md:ml-4 md:mt-0">
                            <a href="{{ route('portfolio.show', $portfolio) }}" class="ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Preview
                            </a>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- Tabs -->
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button onclick="showTab('basic')" class="tab-button border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Basic Info
                                    </button>
                                    <button onclick="showTab('experience')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Experience
                                    </button>
                                    <button onclick="showTab('education')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Education
                                    </button>
                                    <button onclick="showTab('certifications')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Certifications
                                    </button>
                                    <button onclick="showTab('projects')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Projects
                                    </button>
                                    <button onclick="showTab('settings')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Settings
                                    </button>
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            <div class="mt-6">
                                <!-- Basic Info Tab -->
                                <div id="basic-tab" class="tab-content">
                                    <form action="{{ route('portfolio.update', $portfolio) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Portfolio Name</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', $portfolio->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="title" class="block text-sm font-medium text-gray-700">Professional Title</label>
                                            <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('title')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                            <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('bio', $portfolio->bio) }}</textarea>
                                            @error('bio')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                                            <input type="text" name="skills" id="skills" value="{{ old('skills', $portfolio->skills) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., PHP, Laravel, JavaScript">
                                            @error('skills')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $portfolio->contact_email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('contact_email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                            <input type="text" name="location" id="location" value="{{ old('location', $portfolio->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('location')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $portfolio->is_public) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <label for="is_public" class="ml-2 block text-sm text-gray-900">Make portfolio public</label>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Experience Tab -->
                                <div id="experience-tab" class="tab-content hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Work Experience</h3>
                                        <button type="button" onclick="openExperienceModal()" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                            Add Experience
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        @forelse($portfolio->experiences as $experience)
                                            <div class="bg-white border rounded-lg p-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $experience->company }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $experience->position }}</p>
                                                        <p class="text-sm text-gray-500">{{ $experience->location }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $experience->start_date->format('M Y') }} - 
                                                            {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <button onclick="editExperience({{ $experience->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <form action="{{ route('portfolio.experience.destroy', [$portfolio, $experience]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this experience?')">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 text-center py-4">No experiences added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Education Tab -->
                                <div id="education-tab" class="tab-content hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Education</h3>
                                        <button type="button" onclick="openEducationModal()" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                            Add Education
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        @forelse($portfolio->education as $education)
                                            <div class="bg-white border rounded-lg p-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $education->institution }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $education->degree }}</p>
                                                        <p class="text-sm text-gray-500">{{ $education->field_of_study }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $education->start_date->format('M Y') }} - 
                                                            {{ $education->is_current ? 'Present' : $education->end_date->format('M Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <button onclick="editEducation({{ $education->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <form action="{{ route('portfolio.education.destroy', [$portfolio, $education]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this education entry?')">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 text-center py-4">No education entries added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Certifications Tab -->
                                <div id="certifications-tab" class="tab-content hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Certifications</h3>
                                        <button type="button" onclick="openCertificationModal()" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                            Add Certification
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        @forelse($portfolio->certifications as $certification)
                                            <div class="bg-white border rounded-lg p-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $certification->name }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $certification->issuer }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            Issued: {{ $certification->issue_date->format('M Y') }}
                                                            @if($certification->expiry_date)
                                                                - Expires: {{ $certification->expiry_date->format('M Y') }}
                                                            @endif
                                                        </p>
                                                        @if($certification->credential_url)
                                                            <a href="{{ $certification->credential_url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900">
                                                                View Credential
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <button onclick="editCertification({{ $certification->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <form action="{{ route('portfolio.certification.destroy', [$portfolio, $certification]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this certification?')">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 text-center py-4">No certifications added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Projects Tab -->
                                <div id="projects-tab" class="tab-content hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Projects</h3>
                                        <button type="button" onclick="openProjectModal()" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                            Add Project
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        @forelse($portfolio->projects as $project)
                                            <div class="bg-white border rounded-lg p-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $project->name }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $project->description }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $project->start_date->format('M Y') }} - 
                                                            {{ $project->is_current ? 'Present' : $project->end_date->format('M Y') }}
                                                        </p>
                                                        @if($project->url)
                                                            <a href="{{ $project->url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900">
                                                                View Project
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <button onclick="editProject({{ $project->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <form action="{{ route('portfolio.project.destroy', [$portfolio, $project]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this project?')">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 text-center py-4">No projects added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Settings Tab -->
                                <div id="settings-tab" class="tab-content hidden">
                                    <form action="{{ route('portfolio.update', $portfolio) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div>
                                            <label for="template_id" class="block text-sm font-medium text-gray-700">Portfolio Template</label>
                                            <select name="template_id" id="template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @foreach($templates as $template)
                                                    <option value="{{ $template->id }}" {{ old('template_id', $portfolio->template_id) == $template->id ? 'selected' : '' }}>
                                                        {{ $template->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('template_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="custom_css" class="block text-sm font-medium text-gray-700">Custom CSS</label>
                                            <textarea name="custom_css" id="custom_css" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">{{ old('custom_css', $portfolio->custom_css) }}</textarea>
                                            @error('custom_css')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="custom_js" class="block text-sm font-medium text-gray-700">Custom JavaScript</label>
                                            <textarea name="custom_js" id="custom_js" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">{{ old('custom_js', $portfolio->custom_js) }}</textarea>
                                            @error('custom_js')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Save Settings
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Experience Modal -->
    <div id="experience-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <form id="experience-form" action="{{ route('portfolio.experience.store', $portfolio) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                            <input type="text" name="company" id="company" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" name="position" id="position" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_current" id="is_current" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_current" class="ml-2 block text-sm text-gray-900">I currently work here</label>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Save</button>
                        <button type="button" onclick="closeExperienceModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Education Modal -->
    <div id="education-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <form id="education-form" action="{{ route('portfolio.education.store', $portfolio) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700">Institution</label>
                            <input type="text" name="institution" id="institution" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="degree" class="block text-sm font-medium text-gray-700">Degree</label>
                            <input type="text" name="degree" id="degree" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="field_of_study" class="block text-sm font-medium text-gray-700">Field of Study</label>
                            <input type="text" name="field_of_study" id="field_of_study" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_current" id="is_current" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_current" class="ml-2 block text-sm text-gray-900">I currently study here</label>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Save</button>
                        <button type="button" onclick="closeEducationModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Certification Modal -->
    <div id="certification-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <form id="certification-form" action="{{ route('portfolio.certification.store', $portfolio) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Certification Name</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="issuer" class="block text-sm font-medium text-gray-700">Issuing Organization</label>
                            <input type="text" name="issuer" id="issuer" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="credential_url" class="block text-sm font-medium text-gray-700">Credential URL</label>
                            <input type="url" name="credential_url" id="credential_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                                <input type="date" name="issue_date" id="issue_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Save</button>
                        <button type="button" onclick="closeCertificationModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Project Modal -->
    <div id="project-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <form id="project-form" action="{{ route('portfolio.project.store', $portfolio) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700">Project URL</label>
                            <input type="url" name="url" id="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_current" id="is_current" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_current" class="ml-2 block text-sm text-gray-900">This is an ongoing project</label>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Save</button>
                        <button type="button" onclick="closeProjectModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected tab content
            document.getElementById(`${tabName}-tab`).classList.remove('hidden');

            // Update tab button styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Style selected tab button
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('border-indigo-500', 'text-indigo-600');
        }

        // Experience modal functions
        function openExperienceModal() {
            document.getElementById('experience-modal').classList.remove('hidden');
        }

        function closeExperienceModal() {
            document.getElementById('experience-modal').classList.add('hidden');
        }

        function editExperience(id) {
            // Fetch experience data and populate form
            fetch(`/portfolio/{{ $portfolio->id }}/experience/${id}`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('experience-form');
                    form.action = `/portfolio/{{ $portfolio->id }}/experience/${id}`;
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('company').value = data.company;
                    document.getElementById('position').value = data.position;
                    document.getElementById('location').value = data.location;
                    document.getElementById('description').value = data.description;
                    document.getElementById('start_date').value = data.start_date;
                    document.getElementById('end_date').value = data.end_date;
                    document.getElementById('is_current').checked = data.is_current;

                    openExperienceModal();
                });
        }

        // Education modal functions
        function openEducationModal() {
            document.getElementById('education-modal').classList.remove('hidden');
        }

        function closeEducationModal() {
            document.getElementById('education-modal').classList.add('hidden');
        }

        function editEducation(id) {
            // Fetch education data and populate form
            fetch(`/portfolio/{{ $portfolio->id }}/education/${id}`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('education-form');
                    form.action = `/portfolio/{{ $portfolio->id }}/education/${id}`;
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('institution').value = data.institution;
                    document.getElementById('degree').value = data.degree;
                    document.getElementById('field_of_study').value = data.field_of_study;
                    document.getElementById('description').value = data.description;
                    document.getElementById('start_date').value = data.start_date;
                    document.getElementById('end_date').value = data.end_date;
                    document.getElementById('is_current').checked = data.is_current;

                    openEducationModal();
                });
        }

        // Certification modal functions
        function openCertificationModal() {
            document.getElementById('certification-modal').classList.remove('hidden');
        }

        function closeCertificationModal() {
            document.getElementById('certification-modal').classList.add('hidden');
        }

        function editCertification(id) {
            // Fetch certification data and populate form
            fetch(`/portfolio/{{ $portfolio->id }}/certification/${id}`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('certification-form');
                    form.action = `/portfolio/{{ $portfolio->id }}/certification/${id}`;
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('name').value = data.name;
                    document.getElementById('issuer').value = data.issuer;
                    document.getElementById('credential_url').value = data.credential_url;
                    document.getElementById('issue_date').value = data.issue_date;
                    document.getElementById('expiry_date').value = data.expiry_date;

                    openCertificationModal();
                });
        }

        // Project modal functions
        function openProjectModal() {
            document.getElementById('project-modal').classList.remove('hidden');
        }

        function closeProjectModal() {
            document.getElementById('project-modal').classList.add('hidden');
        }

        function editProject(id) {
            // Fetch project data and populate form
            fetch(`/portfolio/{{ $portfolio->id }}/project/${id}`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('project-form');
                    form.action = `/portfolio/{{ $portfolio->id }}/project/${id}`;
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description;
                    document.getElementById('url').value = data.url;
                    document.getElementById('start_date').value = data.start_date;
                    document.getElementById('end_date').value = data.end_date;
                    document.getElementById('is_current').checked = data.is_current;

                    openProjectModal();
                });
        }

        // Handle is_current checkbox changes
        document.querySelectorAll('input[name="is_current"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const endDateInput = this.closest('form').querySelector('input[name="end_date"]');
                endDateInput.disabled = this.checked;
                if (this.checked) {
                    endDateInput.value = '';
                }
            });
        });
    </script>
</body>
</html> 