<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @livewire('portfolio-builder', ['portfolioId' => $portfolio->id])
    </div>
</x-app-layout> 