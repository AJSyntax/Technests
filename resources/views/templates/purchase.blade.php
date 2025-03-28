<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-2xl mx-auto">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold mb-2">{{ $template->name }}</h3>
                            <p class="text-gray-600">{{ $template->description }}</p>
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-indigo-600">${{ number_format($template->price, 2) }}</span>
                            </div>
                        </div>

                        <form action="{{ route('templates.process-purchase', $template) }}" method="POST">
                            @csrf
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="credit_card" id="credit_card" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                        <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">Credit Card</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="paypal" id="paypal" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">PayPal</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('portfolios.create') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Purchase Template
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 