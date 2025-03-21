@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold">Create New Portfolio</h2>
                    <p class="text-gray-600 dark:text-gray-400">Choose a template and start building your portfolio</p>
                </div>

                <form action="{{ route('portfolio.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Portfolio Name
                        </label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                            value="{{ old('name') }}"
                            placeholder="My Professional Portfolio">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Choose Template
                        </label>
                        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($templates as $template)
                                <div class="relative">
                                    <input type="radio" name="template_id" id="template_{{ $template->id }}"
                                        value="{{ $template->id }}" class="peer hidden" required
                                        {{ old('template_id') == $template->id ? 'checked' : '' }}>
                                    <label for="template_{{ $template->id }}"
                                        class="block cursor-pointer rounded-lg border-2 border-gray-200 p-4 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 dark:border-gray-700 dark:peer-checked:border-indigo-400 dark:peer-checked:ring-indigo-400">
                                        <div class="aspect-w-16 aspect-h-9 mb-4">
                                            <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}"
                                                class="rounded-md object-cover">
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $template->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $template->description }}</p>
                                        <a href="{{ route('templates.preview', $template->slug) }}" target="_blank"
                                            class="mt-2 inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                            Preview template
                                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('template_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('portfolio.index') }}"
                            class="mr-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:hover:bg-indigo-500">
                            Create Portfolio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 