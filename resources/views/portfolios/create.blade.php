<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('portfolios.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <!-- Portfolio Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Portfolio Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Template Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Select Template</label>
                                
                                <!-- Free Templates -->
                                <div class="mb-8">
                                    <h3 class="text-lg font-semibold mb-4">Free Templates</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($templates as $template)
                                            <div class="relative">
                                                <input type="radio" name="template_id" value="{{ $template->id }}" id="template_{{ $template->id }}" class="peer sr-only" {{ old('template_id') == $template->id ? 'checked' : '' }}>
                                                <label for="template_{{ $template->id }}" class="block p-4 border rounded-lg cursor-pointer peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500">
                                                    <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                                    <h4 class="text-lg font-semibold mb-2">{{ $template->name }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $template->description }}</p>
                                                    <div class="mt-2 text-sm text-green-600">Free</div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Premium Templates -->
                                <div>
                                    <h3 class="text-lg font-semibold mb-4">Premium Templates</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($premiumTemplates as $template)
                                            <div class="relative">
                                                @if(auth()->user()->purchases()->where('template_id', $template->id)->where('status', 'completed')->exists())
                                                    <input type="radio" name="template_id" value="{{ $template->id }}" id="template_{{ $template->id }}" class="peer sr-only" {{ old('template_id') == $template->id ? 'checked' : '' }}>
                                                    <label for="template_{{ $template->id }}" class="block p-4 border rounded-lg cursor-pointer peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500">
                                                        <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                                        <h4 class="text-lg font-semibold mb-2">{{ $template->name }}</h4>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $template->description }}</p>
                                                        <div class="mt-2 text-sm text-indigo-600">Purchased</div>
                                                    </label>
                                                @else
                                                    <div class="block p-4 border rounded-lg opacity-75">
                                                        <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                                        <h4 class="text-lg font-semibold mb-2">{{ $template->name }}</h4>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $template->description }}</p>
                                                        <div class="mt-2">
                                                            <a href="{{ route('templates.purchase', $template) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                                Purchase for ${{ number_format($template->price, 2) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @error('template_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Create Portfolio
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 