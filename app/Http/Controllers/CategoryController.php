<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\QueryParameters;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    private static string $TABLE_NAME = 'categories';
    private static string $TABLE_ID = 'id';
    private static string $TABLE_SLUG = 'slug';
    private static string $TABLE_TITLE = 'title';
    private static string $TABLE_DESCRIPTION = 'description';

    public static string $VIEW_DATA = 'category';
    public static string $VIEW_DATA_COLLECTION = 'categories';

    // GET /categories?page=1&itemsPerPage=20
    public function index(Request $request): View
    {
        $page = $request->query(QueryParameters::$PAGE, QueryParameters::$PAGE_DEFAULT) - 1;
        $itemsPerPage = $request->query(QueryParameters::$ITEMS_PER_PAGE, QueryParameters::$ITEMS_PER_PAGE_DEFAULT);

        $categories = DB::table(CategoryController::$TABLE_NAME)
            ->orderByDesc(CategoryController::$TABLE_ID)
            ->skip($page * $itemsPerPage)
            ->take($itemsPerPage)
            ->get();

        return \view('category.index', [
            QueryParameters::$PAGE => $page + 1,
            QueryParameters::$ITEMS_PER_PAGE => $itemsPerPage,
            CategoryController::$VIEW_DATA_COLLECTION => $categories,
        ]);
    }

    // GET /categories/5
    public function show(int $id): View
    {
        $category = DB::table(CategoryController::$TABLE_NAME)->find($id);

        if ($category != null) {
            return \view('category.show', [
                CategoryController::$VIEW_DATA => $category,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
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
            CategoryController::$TABLE_SLUG => $validatedRequest->slug,
            CategoryController::$TABLE_TITLE => $validatedRequest->title,
            CategoryController::$TABLE_DESCRIPTION => $validatedRequest->description,
        ]);

        return redirect()->action(
            [CategoryController::class, 'show'],
            [CategoryController::$TABLE_ID, $category->id],
        );
    }

    // GET: /categories/edit/5
    public function edit(int $id): View
    {
        // TODO: Authorize

        $category = DB::table(CategoryController::$TABLE_NAME)->find($id);

        if ($category != null) {
            return \view('category.edit', [
                CategoryController::$VIEW_DATA => $category,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // PUT: /categories/edit/5
    public function update(CategoryUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest->id != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $category = DB::table(CategoryController::$TABLE_NAME)->find($id);

        if ($category != null) {
            $category->update([
                CategoryController::$TABLE_SLUG => $validatedRequest->slug,
                CategoryController::$TABLE_TITLE => $validatedRequest->title,
                CategoryController::$TABLE_DESCRIPTION => $validatedRequest->description,
            ]);

            return redirect()->action(
                [CategoryController::class, 'show'],
                [CategoryController::$TABLE_ID, $category->id],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // DELETE: /categories/delete/5
    public function destroy(CategoryDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $category = DB::table(CategoryController::$TABLE_NAME)->find($id);

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
