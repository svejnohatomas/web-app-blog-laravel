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
                <x-text-input type="hidden" name="id" :value="old('id') ? old('id') : $post->id" readonly />

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title') ? old('title') : $post->title" required autofocus autocomplete="title" placeholder="{{ __('Title') }}" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <!-- Excerpt -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="excerpt" :value="__('Excerpt')" />
                        <x-text-input id="excerpt" type="text" name="excerpt" :value="old('excerpt') ? old('excerpt') : $post->excerpt" required autofocus autocomplete="excerpt" placeholder="{{ __('Excerpt') }}" />
                        <x-input-error :messages="$errors->get('excerpt')" />
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea-input id="content" type="text" name="content" required autofocus autocomplete="content" placeholder="{{ __('Content') }}">{{ old('content') ? old('content') : $post->content }}</x-textarea-input>
                        <x-input-error :messages="$errors->get('content')" />
                    </div>

                    <!-- Create -->
                    <div class="flex items-center justify-end">
                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
