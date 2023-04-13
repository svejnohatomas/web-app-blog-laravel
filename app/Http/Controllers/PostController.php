<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
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

        if ($post != null) {
            return \view('post.show', [
                PostController::$VIEW_DATA_POST => $post,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // GET /categories/{categorySlug}/posts/create
    public function create(string $categorySlug): View
    {
        // TODO: Authorize
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
        // TODO: Authorize

        $validatedRequest = $request->validated();

        $post = Post::create([
            'category_id' => $validatedRequest->category_id,
            'user_id' => $validatedRequest->user_id,
            'slug' => $validatedRequest->slug,
            'title' => $validatedRequest->title,
            'excerpt' => $validatedRequest->excerpt,
            'content' => $validatedRequest->content,
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug', $post->slug],
        );
    }

    // GET: /posts/edit/{slug}
    public function edit(string $slug): View
    {
        // TODO: Authorize - Resource owner authorization

        $post = Post::query()
            ->where('slug', '=', $slug)
            ->first();

        if ($post != null) {
            return \view('post.edit', [
                PostController::$VIEW_DATA_POST => $post,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // PUT: /posts/edit/{id}
    public function update(PostUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest->id != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $post = Post::query()->find($id);

        if ($post != null) {
            $post->update([
                'slug' => $validatedRequest->slug,
                'title' => $validatedRequest->title,
                'excerpt' => $validatedRequest->excerpt,
                'content' => $validatedRequest->content,
            ]);

            return redirect()->action(
                [PostController::class, 'show'],
                ['slug', $post->slug],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // DELETE: /posts/delete/{id}
    public function destroy(PostDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $post = Post::query()->find($id);

        if ($post != null) {
            $post->delete();
            return \redirect()->action(
                [PostController::class, 'index'],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
