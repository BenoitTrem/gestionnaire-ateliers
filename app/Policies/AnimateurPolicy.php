<?php

namespace App\Policies;

use App\Models\Atelier;
use Illuminate\Auth\Access\Response;
use App\Models\Animateur;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

/**
 * @author John Sebastian Zuleta Franco
 */

class AnimateurPolicy
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
    public function view(User $user, Animateur $animateur): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Animateur $animateur): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Animateur $animateur): bool
    {
        return Gate::allows('organisateur');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Animateur $animateur): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur')){
            return true;
        }
        return false;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Animateur $animateur): bool
    {
        return Gate::allows('organisateur');
    }

    public function atelier_ajout(User $user, Animateur $animateur , Atelier $atelier): bool
    {
        if (Gate::allows('estAdmin')) {
            return true;
        }else if (Gate::allows('organisateur') ){
            return true;
        }
        return false;

    }

}
