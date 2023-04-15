<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3">
            <div class="flex-1">
                <h2 class="text-gray-800 dark:text-gray-200 leading-tight font-semibold text-xl">
                    {{ $category->title }}
                </h2>

            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('post.create', ['categorySlug' => $category->slug]) }}">New Post</a>
            </div>

            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('category.edit', ['slug' => $category->slug]) }}">{{ __('Edit') }}</a>
            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <form method="POST" action="{{ route('category.destroy', ['id' => $category->id]) }}">
                    @method('DELETE')
                    @csrf
                    <button>Delete</button>
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
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex space-x-3">
                            <div class="flex-1">
                                <a href="{{ route('post.show', ['slug' => $item->slug]) }}">
                                    <h3>{{ $item->title }}</h3>
                                </a>
                            </div>
                            <div class="flex-none">
                                <a href="{{ route('post.edit', ['slug' => $item->slug]) }}">{{ __('Edit') }}</a>
                            </div>
                            <div class="flex-none">
                                <form method="POST" action="{{ route('post.destroy', ['id' => $item->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button>Delete</button>
                                </form>
                            </div>
                        </div>

                        <div class="my-3">
                            <p>{{ $item->excerpt }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-1">
                                <span>{{ $item->author->name }}</span>
                            </div>
                            <div class="flex-none">
                                @if($item->created_at != null)
                                    <span>{{ $item->created_at }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a class="text-gray-900 hover:text-gray-700 dark:text-gray-100 hover:dark:text-gray-400"
                               aria-label="all posts" href="{{ route('post.show', ['slug' => $item->slug]) }}">View →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>



