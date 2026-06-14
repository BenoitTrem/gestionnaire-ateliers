<?php

namespace App\Providers;

use App\Http\Livewire\ListeAteliers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('liste-ateliers', ListeAteliers::class);
        Gate::define('estAdmin', fn(User $user) => $user->estAdmin());
        Gate::define('organisateur', fn(User $user) => $user->organisateur());


        /**
         * @author John Sabastian Zuleta Franco
         */
        Gate::define('utilisateur', fn(User $user) => $user->utilisateur());

    }
}
