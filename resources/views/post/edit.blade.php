<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('post.update', ['id' => $post->id]) }}">
                @method('PUT')
                @csrf

                <!-- Id -->
                <div class="hidden">
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id') ? old('id') : $post->id" required autofocus autocomplete="id" />
                </div>

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title') ? old('title') : $post->title" required autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Slug -->
                    <div>
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug') ? old('slug') : $post->slug" readonly disabled />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <x-input-label for="excerpt" :value="__('Excerpt')" />
                        <x-text-input id="excerpt" class="block mt-1 w-full" type="text" name="excerpt" :value="old('excerpt') ? old('excerpt') : $post->excerpt" required autofocus autocomplete="excerpt" />
                        <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <x-text-input id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content') ? old('content') : $post->content" required autofocus autocomplete="content" />
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
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
