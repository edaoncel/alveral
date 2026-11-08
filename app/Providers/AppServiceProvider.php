<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;
use App\Models\ContactMessage;

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

    // 2. Sadece Sizin Admin Panelinize Özel Bildirimler ve Sayaçlar
    View::composer('admin.*', function ($view) {
        $unreadCount = ContactMessage::where('is_read', false)->count();
        $updatedTodayCount = Product::whereDate('updated_at', today())
                                    ->whereColumn('updated_at', '>', 'created_at')
                                    ->count();

        $view->with(compact('unreadCount', 'updatedTodayCount'));
    });
    }
}