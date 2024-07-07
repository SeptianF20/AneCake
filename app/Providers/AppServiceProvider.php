<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Helpers\ProductHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Pagination\Paginator::useBootstrap();
 View::composer('*', function ($view) {
            $lowStockProducts = ProductHelper::getLowStockProducts();
            $view->with('lowStockProducts', $lowStockProducts);
        });
    }

}
