<?php

namespace App\Policies;

use App\Models\StockLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StockLogPolicy
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
    public function view(User $user, StockLog $stockLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->is_blocked;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockLog $stockLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockLog $stockLog): bool
    {
        return !$user->is_blocked;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockLog $stockLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockLog $stockLog): bool
    {
        return false;
    }
}
