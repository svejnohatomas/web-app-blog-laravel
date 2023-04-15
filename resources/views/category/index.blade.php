<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Categories') }}
                </h2>
            </div>
            <div class="flex-none">
                <a href="{{ route('category.create') }}" class="text-gray-800 dark:text-gray-200">New Category</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($categories as $item)
                <article class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg {{ $loop->first ? '' : 'mt-6' }}">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex space-x-3">
                            <div class="flex-1">
                                <a href="{{ route('category.show', ['slug' => $item->slug]) }}">
                                    <h3>{{ $item->title }}</h3>
                                </a>
                            </div>
                            <div class="flex-none">
                                <a href="{{ route('category.edit', ['slug' => $item->slug]) }}">{{ __('Edit') }}</a>
                            </div>
                            <div class="flex-none">
                                <form method="POST" action="{{ route('category.destroy', ['id' => $item->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button>Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="my-3">
                            <p>{{ $item->description }}</p>
                        </div>
                        <div class="flex justify-end">
                            <a class="text-gray-900 hover:text-gray-700 dark:text-gray-100 hover:dark:text-gray-400" aria-label="all posts" href="{{ route('category.show', ['slug' => $item->slug]) }}">View Posts →</a>
                        </div>
                    </div>
                </article>
            @endforeach

            @if($categories->total() > $categories->perPage())
                <div class="mt-6 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
