<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ThongBao;

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
        // Chỉ share thông báo cho các view của parent, không ghi đè admin views
        View::composer(['layouts.user', 'parent.*'], function ($view) {
            if (Auth::check()) {
                $userThongbaos = ThongBao::where('user_id', Auth::user()->id)
                    ->where('trangthai', 'đã duyệt')
                    ->orderBy('created_at', 'desc')
                    ->take(6)->get();
                $view->with('userThongbaos', $userThongbaos);
            }
        });
    }
}
