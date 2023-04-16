<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('post.store') }}">
                @csrf

                <x-text-input type="hidden" name="category_id" :value="old('category_id') ? old('category_id') : $category->id" readonly />

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <!-- Slug -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" type="text" name="slug" :value="old('slug')" required autofocus autocomplete="slug" />
                        <x-input-error :messages="$errors->get('slug')" />
                    </div>

                    <!-- Excerpt -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="excerpt" :value="__('Excerpt')" />
                        <x-text-input id="excerpt" type="text" name="excerpt" :value="old('excerpt')" required autofocus autocomplete="excerpt" />
                        <x-input-error :messages="$errors->get('excerpt')" />
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-text-input id="content" type="text" name="content" :value="old('content')" required autofocus autocomplete="content" />
                        <x-input-error :messages="$errors->get('content')" />
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
