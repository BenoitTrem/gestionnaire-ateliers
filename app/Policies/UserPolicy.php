<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Local;
use App\Models\User;
use Illuminate\Support\Facades\Gate;





/**
 * @author John Sebastian Zuleta Franco
 */

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */


    public function forceDelete(User $user): bool
    {
        return true;
    }

    public function updateRole(User $user): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;
    }
}

