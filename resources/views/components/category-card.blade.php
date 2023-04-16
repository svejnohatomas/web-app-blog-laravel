@props(['category'])

<article {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg']) }}>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex space-x-3">
            <div class="flex-1">
                <h3 class="font-bold text-lg">{{ $category->title }}</h3>
            </div>
            <div class="flex-none">
                <a href="{{ route('category.edit', ['slug' => $category->slug]) }}">
                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                </a>
            </div>
            <div class="flex-none">
                <form method="POST" action="{{ route('category.destroy', ['id' => $category->id]) }}">
                    @method('DELETE')
                    @csrf
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </form>
            </div>
        </div>
        <div class="my-3">
            <p>{{ $category->description }}</p>
        </div>
        <div class="flex justify-end">
            <a aria-label="all posts" href="{{ route('category.show', ['slug' => $category->slug]) }}">
                <x-secondary-button>{{ __('View Posts') }} →</x-secondary-button>
            </a>
        </div>
    </div>
</article>
