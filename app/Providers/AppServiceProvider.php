<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 💡 Paginatorを動かすための重要な宣言です
use Illuminate\Pagination\Paginator;

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
       // Paginator::useBootstrap4();
    }
}