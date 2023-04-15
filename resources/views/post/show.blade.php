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
                            <!-- TODO: Fix link -->
                            <div class="flex-none"><a class="underline hover:no-underline" href="#">{{ $post->author->name }}</a></div>
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
                                                let commentsContainer = document.getElementById("commentsContainer");
                                                const div = document.createElement("div");
                                                div.classList.add("mt-4");
                                                const h4 = document.createElement("h4");
                                                h4.innerText = "{{ Auth::user()->name }} (now)";
                                                const p = document.createElement("p");
                                                p.classList.add("px-2", "italic");
                                                p.innerText = comment;

                                                div.append(h4);
                                                div.append(p);
                                                commentsContainer.prepend(div);

                                                document.getElementById("commentInput").value = "";
                                            }
                                        }
                                        xhr.open("POST", "{{ route('comment.store') }}", true);
                                        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                                        xhr.send(data);
                                    }
                                }
                            </script>

                            <div class="text-gray-800">
                                <textarea id="commentInput" class="form-textarea w-full px-4 py-3 rounded"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button onclick="addComment()">Add Comment</button>
                            </div>
                        </div>
                        <!-- TODO: Form for adding comments -->

                        <div id="commentsContainer">
                            @foreach($comments as $item)
                                <div class="mt-4">
                                    <!-- TODO: Fix link -->
                                    <h4><a class="underline hover:no-underline" href="#">{{ $item->author->name }}</a> ({{ $item->created_at }})</h4>
                                    <p class="px-2 italic">{{ $item->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
