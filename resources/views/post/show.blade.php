@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-3">
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $post->title }}
                </h2>
            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <a href="{{ route('post.edit', ['slug' => $post->slug]) }}">{{ __('Edit') }}</a>
            </div>
            <div class="flex-none text-gray-800 dark:text-gray-200">
                <form method="POST" action="{{ route('post.destroy', ['id' => $post->id]) }}">
                    @method('DELETE')
                    @csrf
                    <button>Delete</button>
                </form>
            </div>
        </div>
    </x-slot>

    <script>
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
                            <div class="flex space-x-3">
                                <div class="flex-1">
                                    <h4>
                                        <a class="underline hover:no-underline" href="{{ URL::to('/') }}/users/${response['user_username']}">
                                            ${response['user_name']}
                                        </a> (${response['created_at'].slice(0, 19).replace('T', ' ')})
                                    </h4>
                                </div>
                                <div class="flex-none text-gray-800 dark:text-gray-200">
                                    <a href="{{ URL::to('/') }}/comments/edit/${response['id']}">Edit</a>
                                </div>
                                <div class="flex-none text-gray-800 dark:text-gray-200">
                                    <form id="commentForm${response['id']}" method="POST" action="{{ URL::to('/') }}/comments/delete/${response['id']}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button onclick="removeComment('${response['id']}')">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div>
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
            <article class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col space-y-8 p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="text-gray-700 dark:text-gray-300 font-bold">
                            <p>{{ $post->excerpt }}</p>
                        </div>
                        <div class="flex space-x-3 mt-2">
                            <div class="flex-1">
                                <a class="underline hover:no-underline" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->title }}</a>
                            </div>
                            <div class="flex-none"><a class="underline hover:no-underline" href="{{ route('user.show', $post->author->username) }}">{{ $post->author->name }}</a></div>
                            <div class="flex-none">{{ $post->created_at }}</span></div>
                        </div>
                        <div>
                            <p class="mt-6">{{ $post->content }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-3">
                        <div>
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Comments') }}</h3>
                        </div>

                        <div class="flex flex-col">
                            <div class="text-gray-800">
                                <textarea id="commentInput" class="form-textarea w-full px-4 py-3 rounded" placeholder="Leave a comment..."></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button onclick="addComment()">Add Comment</button>
                            </div>
                        </div>

                        <div id="commentsContainer">
                            @foreach($comments as $item)
                                <div id="comment{{$item->id}}" class="mt-4">
                                    <div class="flex space-x-3">
                                        <div class="flex-1">
                                            <h4>
                                                <a class="underline hover:no-underline" href="{{ route('user.show', $item->author->username) }}">
                                                    {{ $item->author->name }}
                                                </a> ({{ $item->created_at }})
                                            </h4>
                                        </div>
                                        <div class="flex-none text-gray-800 dark:text-gray-200">
                                            <a href="{{ route('comment.edit', ['id' => $item->id]) }}">{{ __('Edit') }}</a>
                                        </div>
                                        <div class="flex-none text-gray-800 dark:text-gray-200">
                                            <form id="commentForm{{ $item->id }}" method="POST" action="{{ route('comment.destroy', ['id' => $item->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="removeComment('{{ $item->id }}')">Delete</button>
                                            </form>
                                        </div>

                                    </div>
                                    <div>
                                        <p class="px-2 italic">{{ $item->content }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if($comments->total() > $comments->perPage())
                                <div class="mt-6">
                                    {{ $comments->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
