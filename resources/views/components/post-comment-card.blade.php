@props(['comment'])

<div {{ $attributes->merge([]) }}>
    <div class="flex space-x-3 items-center">
        <div class="flex-1">
            <h3>
                <a class="underline hover:no-underline" href="{{ route('user.show', $comment->author->username) }}">
                    {{ $comment->author->name }}
                </a> ({{ $comment->created_at }})
            </h3>
        </div>
        @can('update', $comment)
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('comment.edit', ['id' => $comment->id]) }}">
                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                </a>
            </div>
        @endcan
        @can('delete', $comment)
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <form id="commentForm{{ $comment->id }}" method="POST" action="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                    @method('DELETE')
                    @csrf
                    <x-danger-button onclick="removeComment('{{ $comment->id }}')">{{ __('Delete') }}</x-danger-button>
                </form>
            </div>
        @endcan
    </div>
    <div class="mt-3">
        <p class="px-2 italic">{{ $comment->content }}</p>
    </div>
</div>
