<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3 items-center">
            <div class="flex-1">
                <h2 class="text-gray-800 dark:text-gray-200 leading-tight font-semibold text-xl">
                    {{ $category->title }}
                </h2>

            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('post.create', ['categorySlug' => $category->slug]) }}">
                    <x-secondary-button>{{ __('New Post') }}</x-secondary-button>
                </a>
            </div>

            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('category.edit', ['slug' => $category->slug]) }}">
                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                </a>
            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <form method="POST" action="{{ route('category.destroy', ['id' => $category->id]) }}">
                    @method('DELETE')
                    @csrf
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </form>
            </div>

        </div>
        <div class="mt-3 text-gray-600 dark:text-gray-400 leading-tight">
            <p>{{ $category->description }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($posts as $item)
                <article
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg {{ $loop->first ? '' : 'mt-6' }}">
                    <div class="flex flex-col space-y-3 p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex space-x-3">
                            <div class="flex-1">
                                <a href="{{ route('post.show', ['slug' => $item->slug]) }}">
                                    <h3 class="font-bold text-lg">{{ $item->title }}</h3>
                                </a>
                            </div>
                            <div class="flex-none">
                                <a href="{{ route('post.edit', ['slug' => $item->slug]) }}">
                                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                                </a>
                            </div>
                            <div class="flex-none">
                                <form method="POST" action="{{ route('post.destroy', ['id' => $item->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <p>{{ $item->excerpt }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-1">
                                <a class="underline hover:no-underline" href="{{ route('user.show', $item->author->username) }}">{{ $item->author->name }}</a>
                            </div>
                            <div class="flex-none">
                                @if($item->created_at != null)
                                    <span>{{ $item->created_at }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a class="text-gray-900 hover:text-gray-700 dark:text-gray-100 hover:dark:text-gray-400"
                               aria-label="all posts" href="{{ route('post.show', ['slug' => $item->slug]) }}">
                                <x-secondary-button>{{ __('View') }} →</x-secondary-button>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach

            <x-pagination class="mt-6 p-6" :paginator="$posts" />
        </div>
    </div>
</x-app-layout>



