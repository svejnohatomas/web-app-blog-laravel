<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3 items-center">
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Categories') }}
                </h2>
            </div>
            <div class="flex-none">
                <a href="{{ route('category.create') }}">
                    <x-primary-button>{{ __('New Category') }}</x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex flex-col space-y-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($categories as $item)
                <x-category-card :category="$item" />
            @endforeach

            <x-pagination class="p-6" :paginator="$categories" />
        </div>
    </div>
</x-app-layout>
