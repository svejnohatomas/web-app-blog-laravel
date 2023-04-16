@props(['paginator'])

@if($paginator->total() > $paginator->perPage())
    <div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg']) }}>
        {{ $paginator->appends(request()->input())->links() }}
    </div>
@endif
