<x-app-layout>
    <x-slot name="header">
        <h2 class="text-gray-800 dark:text-gray-200 leading-tight font-semibold text-xl">
            {{ __($category->title) }}
        </h2>
        <div class="mt-3 text-gray-600 dark:text-gray-400 leading-tight">
            <p>{{ $category->description }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($posts as $item)

                {{--                {{ dd($item) }}--}}
                <article
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg {{ $loop->first ? '' : 'mt-6' }}">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <a href="{{ route('post.show', $item->slug) }}">
                                <h3>{{ $item->title }}</h3>
                            </a>
                        </div>
                        <div class="my-3">
                            <p>{{ $item->excerpt }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-1">
                                <span>{{ $item->user->name }}</span>
                            </div>
                            <div class="flex-none">
                                <span>2000-01-01</span>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a class="text-gray-900 hover:text-gray-700 dark:text-gray-100 hover:dark:text-gray-400"
                               aria-label="all posts" href="{{ route('post.show', $item->slug) }}">View →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>



