<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
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

    public function view(User $user, Post $resource): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, Post $resource): bool
    {
        return $user->id === $resource->user_id;
    }

    /**
     * Determine if the given post can be destroyed by the user.
     */
    public function delete(User $user, Post $resource): bool
    {
        return $user->id === $resource->user_id;
    }
}
