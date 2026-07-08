<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Give the admin panel its own session cookie so admin authentication
        // is fully isolated from the public/user (web guard) session. This lets
        // a person stay logged into both the user dashboard and the admin panel
        // at once, and prevents user-session events (e.g. a password reset that
        // flushes the web session) from logging the admin out.
        //
        // This must run in register() because AuthServiceProvider::boot()
        // eagerly resolves the web guard, which builds the session store using
        // config('session.cookie'); by then it is too late to change it.
        if (! $this->app->runningInConsole()) {
            $request = $this->app['request'];

            if ($request->is('admin') || $request->is('admin/*')) {
                config(['session.cookie' => config('session.cookie').'_admin']);
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Password::defaults(function () {
            return Password::min(3);
        });
    }
}
