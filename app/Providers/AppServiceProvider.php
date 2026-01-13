<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ThongBao;
use App\Models\UserThongBao;

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
                // Lấy thông báo từ bảng user_thongbao
                $userThongbaosData = UserThongBao::where('user_id', Auth::user()->id)
                    ->with('thongbao')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();

                // Map để có cấu trúc giống như trước
                $userThongbaos = $userThongbaosData->map(function ($userThongbao) {
                    $thongbao = $userThongbao->thongbao;
                    $thongbao->is_read = $userThongbao->is_read;
                    $thongbao->user_thongbao_id = $userThongbao->id;
                    return $thongbao;
                });

                $view->with('userThongbaos', $userThongbaos);
            }
        });
    }
}
