<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            $cartItemCount = 0;
            if (Auth::check()) {
                $cartItemCount = Cart::where('user_id', Auth::id())->count();
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
