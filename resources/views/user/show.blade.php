<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-center space-x-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <div>
                    <a href="{{ URL::current() }}?show=posts">
                        <x-secondary-button>{{ __('Posts') }}</x-secondary-button>
                    </a>
                </div>
                <div>
                    <a href="{{ URL::current() }}?show=comments">
                        <x-secondary-button>{{ __('Comments') }}</x-secondary-button>
                    </a>
                </div>
            </div>

            @isset($posts)
                <div class="flex flex-col space-y-3 mt-6">
                    @foreach($posts as $item)
                        <x-user-post-card :post="$item" />
                    @endforeach
                </div>

                <x-pagination :paginator="$posts" class="mt-6 p-6" />
            @endisset

            @isset($comments)
                <div class="flex flex-col space-y-3 mt-6">
                    @foreach($comments as $item)
                        <x-user-comment-card :comment="$item" />
                    @endforeach
                </div>

                <x-pagination :paginator="$comments" class="mt-6 p-6" />
            @endisset
        </div>
    </div>
</x-app-layout>
