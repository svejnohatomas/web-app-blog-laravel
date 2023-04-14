<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    public static string $VIEW_DATA_CATEGORY = 'category';
    public static string $VIEW_DATA_CATEGORY_COLLECTION = 'categories';
    public static string $VIEW_DATA_POST_COLLECTION = 'posts';

    // GET /categories
    public function index(Request $request): View
    {
        // TODO: Paginate

        // TODO: Cache
        $categories = Category::query()
            ->orderByDesc('id')
            ->get();

        return \view('category.index', [
            CategoryController::$VIEW_DATA_CATEGORY_COLLECTION => $categories,
        ]);
    }

    // GET /categories/{slug}
    public function show(string $slug): View
    {
        $cacheKey = hash('sha256', "category.$slug");
        $category = cache()->remember($cacheKey, now()->addMinute(), function () use ($slug) {
            return Category::query()
                ->where('slug', '=', $slug)
                ->first();
        });

        if ($category == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        // TODO: Pagination
        $posts = Post::query()
            ->where('posts.category_id', '=', $category->id)
            ->with('user')
            ->with('comments')
            ->orderByDesc('posts.id')
            ->get();

        return \view('category.show', [
            CategoryController::$VIEW_DATA_CATEGORY => $category,
            CategoryController::$VIEW_DATA_POST_COLLECTION => $posts,
        ]);
    }

    // GET /categories/create
    public function create(): View
    {
        // TODO: Authorize

        return \view('category.create');
    }

    // POST /categories/create
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        $category = Category::create([
            'slug' => $validatedRequest['slug'],
            'title' => $validatedRequest['title'],
            'description' => $validatedRequest['description'],
        ]);

        return redirect()->action(
            [CategoryController::class, 'show'],
            ['slug', $category->slug],
        );
    }

    // GET: /categories/edit/{slug}
    public function edit(string $slug): View
    {
        // TODO: Authorize

        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        if ($category != null) {
            return \view('category.edit', [
                CategoryController::$VIEW_DATA_CATEGORY => $category,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // PUT: /categories/edit/{id}
    public function update(CategoryUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest->id != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $category = Category::query()->find($id);

        if ($category != null) {
            $category->update([
                'slug' => $validatedRequest['slug'],
                'title' => $validatedRequest['title'],
                'description' => $validatedRequest['description'],
            ]);

            return redirect()->action(
                [CategoryController::class, 'show'],
                ['slug', $category->slug],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // DELETE: /categories/delete/{id}
    public function destroy(CategoryDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $category = Category::query()->find($id);

        if ($category != null) {
            $category->delete();
            return \redirect()->action(
                [CategoryController::class, 'index'],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
