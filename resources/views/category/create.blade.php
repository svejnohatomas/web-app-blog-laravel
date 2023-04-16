<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('category.store') }}">
                @csrf

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" placeholder="{{ __('Title') }}" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <!-- Slug -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" type="text" name="slug" :value="old('slug')" required autofocus autocomplete="slug" placeholder="{{ __('Slug') }}" />
                        <x-input-error :messages="$errors->get('slug')" />
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-textarea-input id="description" type="text" name="description" :value="old('description')" required autofocus autocomplete="description" placeholder="{{ __('Description') }}" />
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <!-- Create -->
                    <div class="flex items-center justify-end">
                        <x-primary-button>{{ __('Create') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
