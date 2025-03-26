<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Portfolio Templates</h2>
                    <p class="mt-2 text-sm text-gray-600">Choose a template to get started with your portfolio.</p>
                </div>
            </div>

            <!-- Template Categories -->
            <div class="mb-8">
                <div class="sm:hidden">
                    <label for="category" class="sr-only">Select a category</label>
                    <select id="category" name="category" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="all" selected>All Templates</option>
                        <option value="free">Free Templates</option>
                        <option value="premium">Premium Templates</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <a href="#" class="bg-indigo-100 text-indigo-700 rounded-md px-3 py-2 text-sm font-medium" aria-current="page">
                            All Templates
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium">
                            Free Templates
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium">
                            Premium Templates
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Template Grid -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($templates as $template)
                    <div class="group relative">
                        <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg bg-gray-100">
                            <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="object-cover object-center">
                            <div class="flex items-end p-4 opacity-0 group-hover:opacity-100" aria-hidden="true">
                                <div class="w-full rounded-md bg-white bg-opacity-75 px-4 py-2 text-center text-sm font-medium text-gray-900 backdrop-blur backdrop-filter">
                                    Preview
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between space-x-8">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('templates.show', $template) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $template->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $template->description }}</p>
                            </div>
                            <div>
                                @if($template->is_premium)
                                    <p class="text-sm font-medium text-gray-900">${{ number_format($template->price, 2) }}</p>
                                @else
                                    <p class="text-sm font-medium text-green-600">Free</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($templates->isEmpty())
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No templates</h3>
                    <p class="mt-1 text-sm text-gray-500">We're working on adding new templates. Check back soon!</p>
                </div>
            @endif

            <!-- Pagination -->
            @if(method_exists($templates, 'hasPages') && $templates->hasPages())
                <div class="mt-8">
                    {{ $templates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 