<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS schema
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            if (Auth::check()) {
                /** @var \App\Models\User $user **/
                $user = Auth::user();
                $user->load('role');
                $view->with('authUser', $user);
            }
        });
    }
}

