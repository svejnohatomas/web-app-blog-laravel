<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
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

    // GET /posts/{slug}
    public function show(string $slug): View
    {
        $post = Post::query()
            ->where('slug', '=', $slug)
            ->first();

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return \view('post.show', [
            PostController::$VIEW_DATA_POST => $post,
        ]);
    }

    // GET /categories/{categorySlug}/posts/create
    public function create(string $categorySlug): View
    {
        // TODO: Authorize
        $category = Category::query()
            ->where('slug', '=', $categorySlug)
            ->first();
        $userId = Auth::id();

        return \view('post.create', [
            PostController::$VIEW_DATA_CATEGORY => $category,
            'userId' => $userId
        ]);
    }

    // POST /posts/create
    public function store(PostCreateRequest $request): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        $post = Post::create([
            'category_id' => $validatedRequest['category_id'],
            'user_id' => $validatedRequest['user_id'],
            'slug' => $validatedRequest['slug'],
            'title' => $validatedRequest['title'],
            'excerpt' => $validatedRequest['excerpt'],
            'content' => $validatedRequest['content'],
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug' => $post->slug],
        );
    }

    // GET: /posts/edit/{slug}
    public function edit(string $slug): View
    {
        // TODO: Authorize - Resource owner authorization

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
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest['id'] != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $post = Post::query()->find($id);

        if ($post == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $post->update([
            'title' => $validatedRequest['title'],
            'excerpt' => $validatedRequest['excerpt'],
            'content' => $validatedRequest['content'],
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug' => $post->slug],
        );
    }

    // DELETE: /posts/delete/{id}
    public function destroy(PostDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

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
