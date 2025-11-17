<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LopHocController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GiaoVienController;
use App\Http\Controllers\Admin\PhuHuynhController;
use App\Http\Controllers\Admin\HocSinhController;
use App\Http\Controllers\Admin\DiemDanhController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\SucKhoeController;
use App\Http\Controllers\Admin\HocPhiController;
use App\Http\Controllers\Teacher\QuanlyhocsinhController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\ThongtincanhanController;


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
    return view('parent.home');
})->name('parent.home');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/welcome', [AdminController::class, 'index'])->name('admin.welcome');
    Route::resource('lophoc', LopHocController::class)->names('admin.lophoc');
    Route::resource('giaovien', GiaoVienController::class)->names('admin.giaovien');
    Route::resource('nguoidung', UserController::class)->names('admin.nguoidung');
    Route::resource('phuhuynh', PhuHuynhController::class)->names('admin.phuhuynh');
    Route::resource('hocsinh', HocSinhController::class)->names('admin.hocsinh');
    Route::resource('diemdanh', DiemDanhController::class)->names('admin.diemdanh');
    Route::get('admin/diemdanh/{id}', [DiemDanhController::class, 'show'])->name('admin.diemdanh.show');
    // Đánh giá
    Route::resource('danhgia', DanhGiaController::class)->names('admin.danhgia');
    //sức khỏe
    Route::resource('suckhoe', SucKhoeController::class)->names('admin.suckhoe');
    //học phí
    Route::resource('hocphi', HocPhiController::class)->names('admin.hocphi');
});

Route::prefix('teacher')->middleware('teacher')->group(function () {

    Route::get('/', [TeacherController::class, 'index'])->name('teacher.teacher');
    Route::resource('hocsinh', QuanlyhocsinhController::class)->names('teacher.hocsinh');
    Route::resource('thongtincanhan', ThongtincanhanController::class)->names('teacher.thongtincanhan');
});
// Route::get('/teacher', function () {
//     return view('teacher.teacher');
// })->name('teacher.teacher');
// Route::get('/Teacher/chatbot', function () {
//     return view('Teacher.chatbot'); // tạo resources/views/chatbot.blade.php
// });
