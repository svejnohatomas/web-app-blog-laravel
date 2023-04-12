<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentDeleteRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentController extends Controller
{
    private static string $TABLE_NAME = 'comments';
    private static string $TABLE_ID = 'id';
    private static string $TABLE_USER_ID = 'user_id';
    private static string $TABLE_POST_ID = 'post_id';
    private static string $TABLE_CONTENT = 'content';

    public static string $VIEW_DATA = 'comment';
    public static string $VIEW_DATA_COLLECTION = 'comments';

    // POST /comments/create
    public function store(CommentCreateRequest $request): Response
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        Comment::create([
            CommentController::$TABLE_USER_ID => $validatedRequest->user_id,
            CommentController::$TABLE_POST_ID => $validatedRequest->post_id,
            CommentController::$TABLE_CONTENT => $validatedRequest->content,
        ]);

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    // GET /comments/edit/{id}
    public function edit(int $id): View
    {
        // TODO: Authorize - Resource owner authorization

        $comment = DB::table(CommentController::$TABLE_NAME)->find($id);

        if ($comment->exists()) {
            return \view('comment.edit', [
                CommentController::$VIEW_DATA => $comment,
            ]);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
    // PUT /comments/edit/{id}
    public function update(CommentUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest->id != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $comment = DB::table(CommentController::$TABLE_NAME)->find($id);

        if ($comment->exists()) {
            $comment->update([
                CommentController::$TABLE_CONTENT => $validatedRequest->content,
            ]);

            return redirect()->action(
                [PostController::class, 'show'],
                [PostController::$TABLE_ID, $comment->post_id],
            );
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    // DELETE /comments/delete/{id}
    public function destroy(CommentDeleteRequest $request, int $id): Response
    {
        $comment = DB::table(CommentController::$TABLE_NAME)->find($id);

        if ($comment->exists()) {
            $comment->delete();
            return response()->noContent(ResponseAlias::HTTP_NO_CONTENT);
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
