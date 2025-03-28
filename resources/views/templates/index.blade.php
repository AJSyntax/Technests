<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Portfolio Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Free Templates Section -->
            <div class="mb-12">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Free Templates</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templates as $template)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h4 class="text-lg font-semibold mb-2">{{ $template->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">{{ $template->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Free</span>
                                    <a href="{{ route('portfolios.create', ['template' => $template->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Use Template
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Premium Templates Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Premium Templates</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($premiumTemplates as $template)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h4 class="text-lg font-semibold mb-2">{{ $template->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">{{ $template->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">${{ number_format($template->price, 2) }}</span>
                                    <a href="{{ route('templates.purchase', $template) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Purchase
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 