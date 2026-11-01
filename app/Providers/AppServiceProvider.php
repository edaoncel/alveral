<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
            $view->with('menuCategories', Category::where('show_in_menu', true)->get());
        });
    }
}