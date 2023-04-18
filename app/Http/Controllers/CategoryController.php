<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    public static string $VIEW_DATA_CATEGORY = 'category';
    public static string $VIEW_DATA_CATEGORY_COLLECTION = 'categories';
    public static string $VIEW_DATA_POST_COLLECTION = 'posts';

    // GET /categories
    public function index(): View
    {
        $categories = Category::query()
            ->orderByDesc('id')
            ->paginate();

        return \view('category.index', [
            CategoryController::$VIEW_DATA_CATEGORY_COLLECTION => $categories,
        ]);
    }

    // GET /categories/{slug}
    public function show(string $slug): View
    {
        $category = Category::query()
            ->where('slug', '=', $slug)
            ->first();

        if ($category == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $posts = Post::query()
            ->where('posts.category_id', '=', $category->id)
            ->with('author')
            ->orderByDesc('posts.id')
            ->paginate();

        return \view('category.show', [
            CategoryController::$VIEW_DATA_CATEGORY => $category,
            CategoryController::$VIEW_DATA_POST_COLLECTION => $posts,
        ]);
    }

    // GET /categories/create
    public function create(): View
    {
        if (Gate::none(['admin'])) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        return \view('category.create');
    }

    // POST /categories/create
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        if (Gate::none(['admin'])) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        $category = Category::create([
            'slug' => $request['slug'],
            'title' => $request['title'],
            'description' => $request['description'],
        ]);

        return redirect()->action(
            [CategoryController::class, 'show'],
            ['slug' => $category->slug],
        );
    }

    // GET: /categories/edit/{slug}
    public function edit(string $slug): View
    {
        if (Gate::none(['admin', 'moderator'])) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        if ($category == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return \view('category.edit', [
            CategoryController::$VIEW_DATA_CATEGORY => $category,
        ]);
    }

    // PUT: /categories/edit/{id}
    public function update(CategoryUpdateRequest $request, int $id): RedirectResponse
    {
        if (Gate::none(['admin', 'moderator'])) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        if ($request['id'] != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $category = Category::query()->find($id);

        if ($category == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $category->update([
            'title' => $request['title'],
            'description' => $request['description'],
        ]);

        return redirect()->action(
            [CategoryController::class, 'show'],
            ['slug' => $category->slug],
        );
    }

    // DELETE: /categories/delete/{id}
    public function destroy(CategoryDeleteRequest $request, int $id): RedirectResponse
    {
        if (Gate::none(['admin'])) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        $category = Category::query()->find($id);

        if ($category == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $category->delete();
        return \redirect()->action(
            [CategoryController::class, 'index'],
        );
    }
}
