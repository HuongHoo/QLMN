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
        View::composer('*', function ($view) {
            if (Auth::user()) {
                $thongbaos = ThongBao::where('user_id', Auth::user()->id)
                    ->where('trangthai', 'đã duyệt')
                    ->orderBy('created_at', 'desc')
                    ->take(6)->get();
                $view->with('thongbaos', $thongbaos);
            }
        });
    }
}
