<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostController extends Controller
{
    public static string $VIEW_DATA_CATEGORY = 'category';
    public static string $VIEW_DATA_POST = 'post';
    public static string $VIEW_DATA_POST_COLLECTION = 'posts';
    public static string $VIEW_DATA_COMMENT_COLLECTION = 'comments';

    // GET /posts/{slug}
    public function show(string $slug): View
    {
        $post = Post::query()
            ->where('slug', '=', $slug)
            ->with('category')
            ->with('author')
            ->first();

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $comments = Comment::query()
            ->where('post_id', '=', $post->id)
            ->with('author')
            ->orderByDesc('created_at')
            ->paginate();

        return \view('post.show', [
            PostController::$VIEW_DATA_POST => $post,
            PostController::$VIEW_DATA_COMMENT_COLLECTION => $comments,
        ]);
    }

    // GET /categories/{categorySlug}/posts/create
    public function create(string $categorySlug): View
    {
        $category = Category::query()
            ->where('slug', '=', $categorySlug)
            ->first();

        return \view('post.create', [
            PostController::$VIEW_DATA_CATEGORY => $category,
        ]);
    }

    // POST /posts/create
    public function store(PostCreateRequest $request): RedirectResponse
    {
        $post = Post::create([
            'category_id' => $request['category_id'],
            'user_id' => Auth::id(),
            'slug' => $request['slug'],
            'title' => $request['title'],
            'excerpt' => $request['excerpt'],
            'content' => $request['content'],
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug' => $post->slug],
        );
    }

    // GET: /posts/edit/{slug}
    public function edit(string $slug): View
    {
        // TODO: Authorize - Resource owner authorization | Moderator | Admin

        $post = Post::query()
            ->where('slug', '=', $slug)
            ->first();

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return \view('post.edit', [
            PostController::$VIEW_DATA_POST => $post,
        ]);
    }

    // PUT: /posts/edit/{id}
    public function update(PostUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize - Resource owner authorization | Moderator | Admin

        if ($request['id'] != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $post = Post::query()->find($id);

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $post->update([
            'title' => $request['title'],
            'excerpt' => $request['excerpt'],
            'content' => $request['content'],
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug' => $post->slug],
        );
    }

    // DELETE: /posts/delete/{id}
    public function destroy(PostDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize - Resource owner authorization | Moderator | Admin

        $post = Post::query()
            ->with('category')
            ->find($id);

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $post->delete();
        return \redirect()->action(
            [CategoryController::class, 'show'],
            ['slug' => $post->category->slug]
        );
    }
}
