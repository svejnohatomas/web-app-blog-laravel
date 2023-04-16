<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentDeleteRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentController extends Controller
{
    public static string $VIEW_DATA = 'comment';
    public static string $VIEW_DATA_COLLECTION = 'comments';

    // POST /comments/create
    public function store(CommentCreateRequest $request): JsonResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $validatedRequest['post_id'],
            'content' => $validatedRequest['content'],
        ]);

        $user = Auth::user();

        return \response()->json([
            'id' => $comment->id,
            'created_at' => $comment->created_at,
            'user_username' => $user->username,
            'user_name' => $user->name,
            'content' => $comment->content,
        ], ResponseAlias::HTTP_CREATED);
    }

    // GET /comments/edit/{id}
    public function edit(int $id): View
    {
        // TODO: Authorize - Resource owner authorization

        $comment = Comment::query()->find($id);

        if ($comment == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return \view('comment.edit', [
            CommentController::$VIEW_DATA => $comment,
        ]);
    }
    // PUT /comments/edit/{id}
    public function update(CommentUpdateRequest $request, int $id): RedirectResponse
    {
        // TODO: Authorize

        $validatedRequest = $request->validated();

        if ($validatedRequest['id'] != $id) {
            abort(ResponseAlias::HTTP_BAD_REQUEST); // Programmers error
        }

        $comment = Comment::query()
            ->with('post')
            ->find($id);

        if ($comment == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $comment->update([
            'content' => $validatedRequest['content'],
        ]);

        return redirect()->action(
            [PostController::class, 'show'],
            ['slug' => $comment->post->slug],
        );
    }

    // DELETE /comments/delete/{id}
    public function destroy(CommentDeleteRequest $request, int $id): Response
    {
        $comment = Comment::query()->find($id);

        if ($comment == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        $comment->delete();
        return response()->noContent(ResponseAlias::HTTP_NO_CONTENT);
    }
}
