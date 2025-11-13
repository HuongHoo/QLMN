<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GiaoVienController;
use App\Http\Controllers\PhuHuynhController;
use App\Http\Controllers\HocSinhController;
use App\Http\Controllers\DiemDanhController;

// Route::get('/', function () {
//     return view('admin.welcome');
// })->name('admin.welcome');
//Route::resource('lophoc', LopHocController::class);

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/nguoidung', function () {
    return view('user.home');
})->name('user.home');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/welcome', [AdminController::class, 'index'])->name('admin.welcome');
    Route::resource('lophoc', LopHocController::class)->names('admin.lophoc');
    Route::resource('giaovien', GiaoVienController::class)->names('admin.giaovien');
    Route::resource('nguoidung', UserController::class)->names('admin.nguoidung');
    Route::resource('phuhuynh', PhuHuynhController::class)->names('admin.phuhuynh');
    Route::resource('hocsinh', HocSinhController::class)->names('admin.hocsinh');
    Route::resource('diemdanh', DiemDanhController::class)->names('admin.diemdanh');
    Route::get('admin/diemdanh/{id}', [DiemDanhController::class, 'show'])->name('admin.diemdanh.show');
});


Route::get('/teacher', function () {
    return view('Teacher.teacher');
})->name('Teacher.teacher');
