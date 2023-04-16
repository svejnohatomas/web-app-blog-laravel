<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Comment') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                  method="POST" action="{{ route('comment.update', ['id' => $comment->id]) }}">
                @method('PUT')
                @csrf

                <x-text-input type="hidden" name="id" :value="old('id') ? old('id') : $comment->id" readonly />

                <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">
                    <!-- Content -->
                    <div class="flex flex-col space-y-2">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea-input id="content" name="content" required autofocus autocomplete="content" placeholder="Your comment">{{ old('content') ? old('content') : $comment->content }}</x-textarea-input>
                        <x-input-error :messages="$errors->get('content')" />
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
