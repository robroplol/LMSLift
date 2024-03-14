<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-charcoal">
                   <livewire:csv-to-imscc />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
