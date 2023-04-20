@props(['comment'])

<article
    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">

        <div class="flex space-x-3 items-center">
            <div class="flex-none">
                <a class="underline hover:no-underline" href="{{ route('post.show', ['slug' => $comment->post->slug]) }}">
                    <h2>{{ $comment->post->title }}</h2>
                </a>
            </div>
            <div class="flex-1">
                @if($comment->created_at != null)
                    <span>({{ $comment->created_at }})</span>
                @endif
            </div>
            @can('update', $comment)
                <div class="flex-none">
                    <a href="{{ route('comment.edit', ['id' => $comment->id]) }}">
                        <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                    </a>
                </div>
            @endcan
            @can('delete', $comment)
                <div class="flex-none">
                    <form method="POST" action="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                        @method('DELETE')
                        @csrf
                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                    </form>
                </div>
            @endcan
        </div>

        <div class="my-3">
            <p>{{ $comment->content }}</p>
        </div>
    </div>
</article>
