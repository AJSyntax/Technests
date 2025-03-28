@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Template Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">{{ $template->name }}</h1>
                @if($template->is_premium)
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        Premium
                    </span>
                @endif
            </div>
            <p class="mt-2 text-gray-600">{{ $template->description }}</p>
            @if($template->is_premium)
                <p class="mt-2 text-lg font-semibold text-gray-900">Price: ${{ number_format($template->price, 2) }}</p>
            @endif
        </div>

        <!-- Template Preview -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Template Preview</h2>
            <div class="border rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Template Preview Content -->
                    <div class="prose max-w-none">
                        {!! $template->html_template !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('templates.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Back to Templates
            </a>
            @if($template->is_premium)
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Purchase Template
                </button>
            @else
                <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Use Template
                </button>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    {!! $template->css_template !!}
</style>
@endpush
@endsection 