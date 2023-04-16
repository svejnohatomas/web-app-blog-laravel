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
                    <a class="underline hover:no-underline" href="{{ URL::current() }}?show=posts">Posts</a>
                </div>
                <div>
                    <a class="underline hover:no-underline" href="{{ URL::current() }}?show=comments">Comments</a>
                </div>
            </div>

            @isset($posts)
                @foreach($posts as $item)
                    <article
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
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
                                    <a class="underline hover:no-underline" href="{{ route('category.show', $item->category->slug) }}">{{ $item->category->title }}</a>
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

                @if($posts->total() > $posts->perPage())
                    <div class="mt-6 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                @endif
            @endisset

            @isset($comments)
                @foreach($comments as $item)
                    <article
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <div class="flex space-x-3">
                                <div class="flex-none">
                                    <a class="underline hover:no-underline" href="{{ route('post.show', ['slug' => $item->post->slug]) }}">
                                        <h3>{{ $item->post->title }}</h3>
                                    </a>
                                </div>
                                <div class="flex-1">
                                    @if($item->created_at != null)
                                        <span>({{ $item->created_at }})</span>
                                    @endif
                                </div>
                                <div class="flex-none">
                                    <a href="{{ route('comment.edit', ['id' => $item->id]) }}">{{ __('Edit') }}</a>
                                </div>
                                <div class="flex-none">
                                    <form method="POST" action="{{ route('comment.destroy', ['id' => $item->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button>Delete</button>
                                    </form>
                                </div>
                            </div>

                            <div class="my-3">
                                <p>{{ $item->content }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach

                @if($comments->total() > $comments->perPage())
                    <div class="mt-6 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {{ $comments->appends(request()->input())->links() }}
                    </div>
                @endif
            @endisset
        </div>
    </div>

    <!-- Posts -->

    <!-- Comments -->

</x-app-layout>
