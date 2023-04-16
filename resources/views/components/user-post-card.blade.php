@props(['post'])

<article
    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex flex-col space-y-4 p-6 text-gray-900 dark:text-gray-100">

        <div class="flex space-x-3 items-center">
            <div class="flex-1">
                <h3 class="font-bold text-lg">{{ $post->title }}</h3>
            </div>
            <div class="flex-none">
                <a href="{{ route('post.edit', ['slug' => $post->slug]) }}">
                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                </a>
            </div>
            <div class="flex-none">
                <form method="POST" action="{{ route('post.destroy', ['id' => $post->id]) }}">
                    @method('DELETE')
                    @csrf
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </form>
            </div>
        </div>

        <div class="my-3">
            <p>{{ $post->excerpt }}</p>
        </div>

        <div class="flex flex-col sm:flex-row">
            <div class="flex-1">
                <a class="underline hover:no-underline" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->title }}</a>
            </div>
            <div class="flex-none">
                @if($post->created_at != null)
                    <span>{{ $post->created_at }}</span>
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <a class="text-gray-900 hover:text-gray-700 dark:text-gray-100 hover:dark:text-gray-400"
               aria-label="all posts" href="{{ route('post.show', ['slug' => $post->slug]) }}">
                <x-secondary-button>{{ __('View') }} →</x-secondary-button>
            </a>
        </div>
    </div>
</article>
