<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @livewire('portfolio-builder')
    </div>
</x-app-layout> 