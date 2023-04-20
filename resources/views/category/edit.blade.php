<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Category') }}
        </h1>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('category.update', ['id' => $category->id]) }}">
                @method('PUT')
                @csrf

                <!-- Id -->
                <x-text-input type="hidden" name="id" :value="old('id') ? old('id') : $category->id" readonly />

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title') ? old('title') : $category->title" required autofocus autocomplete="title" placeholder="{{ __('Title') }}" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-textarea-input id="description" type="text" name="description" required autofocus autocomplete="description" placeholder="{{ __('Description') }}">{{ old('description') ? old('description') : $category->description }}</x-textarea-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <!-- Update -->
                    <div class="flex items-center justify-end">
                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
