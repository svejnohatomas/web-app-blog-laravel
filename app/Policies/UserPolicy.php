<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isModerator();
    }

    public function view(User $user, User $resource): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $resource): bool
    {
        return false;
    }

    public function delete(User $user, User $resource): bool
    {
        return false;
    }
}
