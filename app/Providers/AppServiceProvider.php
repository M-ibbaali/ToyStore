<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Share categories and cart count with frontend views
        view()->composer('layouts.frontend', \App\Http\View\Composers\FrontendComposer::class);

        // Register Cart Merging Listener
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\MergeCartAfterLogin::class
        );
    }
}
