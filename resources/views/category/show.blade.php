@php use App\Models\Post; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3 items-center">
            <div class="flex-1">
                <h1 class="text-gray-800 dark:text-gray-200 leading-tight font-semibold text-xl">
                    {{ $category->title }}
                </h1>

            </div>
            @can('create', Post::class)
                <div class="flex-none text-gray-800 dark:text-gray-200">
                    <a href="{{ route('post.create', ['categorySlug' => $category->slug]) }}">
                        <x-secondary-button>{{ __('New Post') }}</x-secondary-button>
                    </a>
                </div>
            @endcan

            @can('update', $category)
                <div class="flex-none text-gray-800 dark:text-gray-200">
                    <a href="{{ route('category.edit', ['slug' => $category->slug]) }}">
                        <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                    </a>
                </div>
            @endcan

            @can('delete', $category)
                <div class="flex-none text-gray-800 dark:text-gray-200">
                    <form method="POST" action="{{ route('category.destroy', ['id' => $category->id]) }}">
                        @method('DELETE')
                        @csrf
                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                    </form>
                </div>
            @endcan

        </div>
        <div class="mt-3 text-gray-600 dark:text-gray-400 leading-tight">
            <p>{{ $category->description }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($posts as $item)
                <x-category-post-card class="mt-6" :post="$item" />
            @endforeach

            <x-pagination class="mt-6 p-6" :paginator="$posts" />
        </div>
    </div>
</x-app-layout>



