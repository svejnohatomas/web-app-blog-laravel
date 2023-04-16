@props(['comment'])

<div {{ $attributes->merge([]) }}>
    <div class="flex space-x-3 items-center">
        <div class="flex-1">
            <h4>
                <a class="underline hover:no-underline" href="{{ route('user.show', $comment->author->username) }}">
                    {{ $comment->author->name }}
                </a> ({{ $comment->created_at }})
            </h4>
        </div>
        <div class="flex-none text-gray-800 dark:text-gray-200">
            <a href="{{ route('comment.edit', ['id' => $comment->id]) }}">
                <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
            </a>
        </div>
        <div class="flex-none text-gray-800 dark:text-gray-200">
            <form id="commentForm{{ $comment->id }}" method="POST" action="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                @method('DELETE')
                @csrf
                <button onclick="removeComment('{{ $comment->id }}')">
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </button>
            </form>
        </div>

    </div>
    <div class="mt-3">
        <p class="px-2 italic">{{ $comment->content }}</p>
    </div>
</div>
