<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicyWeb
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {

        if ($user->role !== UserRole::ADMIN->value) {
            return false;
        }

        return $user->id === $model->id || $model->role !== UserRole::ADMIN->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->role !== UserRole::ADMIN->value) {
            return false;
        }

        return $model->role !== UserRole::ADMIN->value;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
