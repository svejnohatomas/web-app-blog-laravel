<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Category') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('category.update', ['id' => $category->id]) }}">
                @method('PUT')
                @csrf

                <!-- Id -->
                <div class="hidden">
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id') ? old('id') : $category->id" required autofocus autocomplete="id" />
                </div>

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title') ? old('title') : $category->title" required autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Slug -->
                    <div>
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="$category->slug" readonly disabled />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description') ? old('description') : $category->description" required autofocus autocomplete="description" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Create -->
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
