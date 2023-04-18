<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    private static string $VIEW_DATA_USER = 'user';
    private static string $VIEW_DATA_POSTS = 'posts';
    private static string $VIEW_DATA_COMMENTS = 'comments';

    // GET /users/{username}
    public function show(Request $request, string $username): View
    {
        $user = User::query()
            ->where('username', '=', $username)
            ->first();

        if ($user == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($request->user()->cannot('view', $user)) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        $show = strtolower($request->query('show', 'posts'));

        if ($show == 'posts') {
            $posts = Post::query()
                ->where('user_id', '=', $user->id)
                ->with('category')
                ->paginate(pageName: 'posts');

            return \view('user.show', [
                UserController::$VIEW_DATA_USER => $user,
                UserController::$VIEW_DATA_POSTS => $posts,
            ]);
        } else if ($show == 'comments') {
            $comments = Comment::query()
                ->where('user_id', '=', $user->id)
                ->with('post')
                ->paginate(pageName: 'comments');

            return \view('user.show', [
                UserController::$VIEW_DATA_USER => $user,
                UserController::$VIEW_DATA_COMMENTS => $comments,
            ]);
        } else {
            abort(ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
}
