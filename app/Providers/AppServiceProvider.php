<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
       // Bagian ini memanggil fungsi share() untuk membagikan data 'keranjang'
        // kepada view 'navbar.blade.php'
        View::composer('template.navbar', function ($view) {
            $view->with('keranjang', session('keranjang'));
        });
    }
}
