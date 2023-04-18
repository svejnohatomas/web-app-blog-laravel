<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator() || $user->isModerator()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comment $resource): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given comment can be updated by the user.
     */
    public function update(User $user, Comment $resource): bool
    {
        return $user->id === $resource->user_id;
    }

    /**
     * Determine if the given comment can be destroyed by the user.
     */
    public function delete(User $user, Comment $resource): bool
    {
        return $user->id === $resource->user_id;
    }
}
