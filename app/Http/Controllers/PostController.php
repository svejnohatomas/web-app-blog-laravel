<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\QueryParameters;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostController extends Controller
{
    private static string $TABLE_NAME = 'posts';
    private static string $TABLE_CATEGORY_ID = 'category_id';
    private static string $TABLE_USER_ID = 'user_id';
    private static string $TABLE_SLUG = 'slug';
    private static string $TABLE_TITLE = 'title';
    private static string $TABLE_EXCERPT = 'excerpt';
    private static string $TABLE_CONTENT = 'content';

    public static string $TABLE_ID = 'id';
    public static string $VIEW_DATA = 'post';
    public static string $VIEW_DATA_COLLECTION = 'posts';

    // GET /categories/5/posts
    public function index(Request $request, int $categoryId): View
    {
        $page = $request->query(QueryParameters::$PAGE, QueryParameters::$PAGE_DEFAULT) - 1;
        $itemsPerPage = $request->query(QueryParameters::$ITEMS_PER_PAGE, QueryParameters::$ITEMS_PER_PAGE_DEFAULT);

        $posts = DB::table(PostController::$TABLE_NAME)
            ->where(PostController::$TABLE_CATEGORY_ID, '=', $categoryId)
            ->orderByDesc(PostController::$TABLE_ID)
            ->skip($page * $itemsPerPage)
            ->take($itemsPerPage)
            ->get();

        return \view('post.index', [
            QueryParameters::$PAGE => $page + 1,
            QueryParameters::$ITEMS_PER_PAGE => $itemsPerPage,
            PostController::$VIEW_DATA_COLLECTION => $posts,
        ]);
    }

    // GET /posts/5
    public function show(int $id): View
    {
        $post = DB::table(PostController::$TABLE_NAME)->find($id);

        if ($post->exists()) {
            return \view('post.show', [
                PostController::$VIEW_DATA => $post,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // GET /posts/create
    public function create(): View
    {
        // TODO: Authorize

        return \view('post.create');
    }

    // POST /posts/create
    public function store(PostCreateRequest $request): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        $post = Post::create([
            PostController::$TABLE_CATEGORY_ID => $validatedRequest->category_id,
            PostController::$TABLE_USER_ID => $validatedRequest->user_id,
            PostController::$TABLE_SLUG => $validatedRequest->slug,
            PostController::$TABLE_TITLE => $validatedRequest->title,
            PostController::$TABLE_EXCERPT => $validatedRequest->excerpt,
            PostController::$TABLE_CONTENT => $validatedRequest->content,
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            [PostController::$TABLE_ID, $post->id],
        );
    }

    // GET: /posts/edit/5
    public function edit(int $id): View
    {
        // TODO: Authorize - Resource owner authorization

        $post = DB::table(PostController::$TABLE_NAME)->find($id);

        if ($post->exists()) {
            return \view('post.edit', [
                PostController::$VIEW_DATA => $post,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // PUT: /posts/edit/5
    public function update(PostUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest->id != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $post = DB::table(PostController::$TABLE_NAME)->find($id);

        if ($post->exists()) {
            $post->update([
                PostController::$TABLE_SLUG => $validatedRequest->slug,
                PostController::$TABLE_TITLE => $validatedRequest->title,
                PostController::$TABLE_EXCERPT => $validatedRequest->excerpt,
                PostController::$TABLE_CONTENT => $validatedRequest->content,
            ]);

            return redirect()->action(
                [PostController::class, 'show'],
                [PostController::$TABLE_ID, $post->id],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // DELETE: /posts/delete/5
    public function destroy(PostDeleteRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $post = DB::table(PostController::$TABLE_NAME)->find($id);

        if ($post->exists()) {
            $post->delete();
            return \redirect()->action(
                [PostController::class, 'index'],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
