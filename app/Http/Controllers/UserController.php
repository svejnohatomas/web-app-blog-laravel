<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    private static string $VIEW_DATA_USER = 'user';

    // GET /users/{username}
    public function show(string $username): View
    {
        $user = User::query()
            ->where('username', '=', $username)
            ->with('posts')
            ->with('comments')
            ->first();

        if ($user == null) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return \view('user.show', [
            UserController::$VIEW_DATA_USER => $user,
        ]);
    }
}
