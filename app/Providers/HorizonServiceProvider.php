<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Boot your application services.
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        $authorizedEmails = explode(',', config('horizon.authorized_emails'));

        Gate::define('viewHorizon', function ($user = null) use ($authorizedEmails) {
            return in_array(optional($user)->email, $authorizedEmails);
        });
    }
}
