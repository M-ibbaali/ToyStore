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

        // Register Observers
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\ContactMessage::observe(\App\Observers\ContactMessageObserver::class);
        
        // Share notifications with admin layout
        view()->composer('layouts.admin', \App\View\Composers\AdminNotificationComposer::class);
    }
}
