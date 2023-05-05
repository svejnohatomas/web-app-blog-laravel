@php use App\Models\Comment; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3 items-center">
            <div class="flex-1">
                <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $post->title }}
                </h1>
            </div>
            @can('update', $post)
                <div class="flex-none text-gray-800 dark:text-gray-200">
                    <a href="{{ route('post.edit', ['slug' => $post->slug]) }}">
                        <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                    </a>
                </div>
            @endcan
            @can('delete', $post)
                <div class="flex-none text-gray-800 dark:text-gray-200">
                    <form method="POST" action="{{ route('post.destroy', ['id' => $post->id]) }}">
                        @method('DELETE')
                        @csrf
                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <script>
        <!-- TODO: FIX JS SCRIPTS -->
        function addComment() {
            let comment = document.getElementById("commentInput").value;

            if (new RegExp(".+").test(comment)) {
                let data = new FormData();
                data.append("post_id", "{{ $post->id }}");
                data.append("content", comment);

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 201) {
                        const response = JSON.parse(this.responseText);

                        const div = document.createElement("div");
                        div.id = `comment${response['id']}`
                        div.classList.add("mt-4");

                        div.innerHTML = `
                            <div class="flex space-x-3 items-center">
                                <div class="flex-1">
                                    <h3>
                                        <a class="underline hover:no-underline" href="{{ URL::to('/') }}/users/${response['user_username']}">
                                            ${response['user_name']}
                                        </a> (${response['created_at'].slice(0, 19).replace('T', ' ')})
                                    </h3>
                                </div>
                                <div class="flex-none text-gray-800 dark:text-gray-200">
                                    <a href="{{ URL::to('/') }}/comments/edit/${response['id']}">
                                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Edit</button>
                                    </a>
                                </div>
                                <div class="flex-none text-gray-800 dark:text-gray-200">
                                    <form id="commentForm${response['id']}" method="POST" action="{{ URL::to('/') }}/comments/delete/${response['id']}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" onclick="removeComment('${response['id']}')">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="px-2 italic">${response['content']}</p>
                            </div>`;

                        document.getElementById("commentsContainer").prepend(div);
                        document.getElementById("commentInput").value = "";
                    }
                }
                xhr.open("POST", "{{ route('comment.store') }}", true);
                xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                xhr.send(data);
            }
        }

        function removeComment(id) {
            document.getElementById("commentForm" + id).submit();
            document.getElementById("comment" + id).remove();
        }
    </script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col space-y-8 p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="text-gray-700 dark:text-gray-300 font-bold">
                            <p>{{ $post->excerpt }}</p>
                        </div>
                        <div class="flex space-x-3 mt-2">
                            <div class="flex-1">
                                <a class="underline hover:no-underline"
                                   href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->title }}</a>
                            </div>
                            <div class="flex-none">
                                <a class="underline hover:no-underline"
                                   href="{{ route('user.show', $post->author->username) }}">{{ $post->author->name }}</a>
                            </div>
                            <div class="flex-none">{{ $post->created_at }}</span></div>
                        </div>
                        <div>
                            <p class="mt-6">{{ $post->content }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Comments') }}</h2>
                        </div>

                        @can('create', Comment::class)
                            <div class="flex flex-col space-y-3">
                                <div>
                                    <x-textarea-input id="commentInput"
                                                      aria-label="Input textbox for comment"
                                                      placeholder="{{ __('Leave a comment...') }}"></x-textarea-input>
                                </div>
                                <div class="flex justify-end">
                                    <x-primary-button onclick="addComment()">{{ __('Add Comment') }}</x-primary-button>
                                </div>
                            </div>
                        @endcan
                        @can('viewAny', Comment::class)
                            <div id="commentsContainer" class="flex flex-col pt-4 space-y-6">
                                @foreach($comments as $item)
                                    <x-post-comment-card id="comment{{$item->id}}" :comment="$item"/>
                                @endforeach
                            </div>
                        @endcan
                    </div>
                    @can('viewAny', Comment::class)
                        <x-pagination :paginator="$comments"/>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
