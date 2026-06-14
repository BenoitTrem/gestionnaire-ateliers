<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Telescope::night();


        $this->hideSensitiveRequestDetails();

        $isLocal = $this->app->environment('local');

        Telescope::filter(function (IncomingEntry $entry) use ($isLocal) {
            return $isLocal ||
                $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);
        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     * @author John Sebastian Zuleta Franco
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        // Applique le gate uniquement dans les environnements non-locaux
        Gate::define('viewTelescope', function ($user) {
                return $user->role === 1;
        });

    }

    /**
     * @return void
     * @author John Sebastian Zuleta Franco
     * Cela protège toutes les routes Telescope (/telescope/*) et pas seulement /telescope.
     */

    public function boot(): void
    {
        parent::boot();

        Telescope::auth(function ($request) {
            return optional($request->user())->role === 1; // Seuls les organisateurs
        });
    }
}
