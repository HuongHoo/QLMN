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
use App\Http\Controllers\Teacher\DDlopController;
use App\Http\Controllers\Admin\DuyetThongBaoController;
use App\Http\Controllers\Teacher\ThongBaoController;
use App\Http\Controllers\User\ParentController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ChatbotController;


// Route::get('/', function () {
//     return view('admin.welcome');
// })->name('admin.welcome');
//Route::resource('lophoc', LopHocController::class);

// Trang chủ public (cho khách chưa đăng nhập)
Route::get('/', [ParentController::class, 'home'])->name('public.home');

Auth::routes();

// Chatbot Routes
Route::post('/chatbot/send', [ChatbotController::class, 'chat'])->name('chatbot.send');
Route::post('/chatbot/quick', [ChatbotController::class, 'quickReply'])->name('chatbot.quick');

// Social Login Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Parent routes
Route::prefix('nguoidung')->middleware('auth')->group(function () {
    Route::get('/', [ParentController::class, 'index'])->name('parent.home');
    Route::get('/thongtin-be', [ParentController::class, 'thongtinBe'])->name('parent.thongtinbe');
    Route::get('/thongtin-be/{id}', [ParentController::class, 'chiTietBe'])->name('parent.chitietbe');
    Route::get('/diem-danh', [ParentController::class, 'diemDanh'])->name('parent.diemdanh');
    Route::get('/hoc-phi', [ParentController::class, 'hocPhi'])->name('parent.hocphi');
    Route::get('/danh-gia', [ParentController::class, 'danhGia'])->name('parent.danhgia');
    Route::get('/suc-khoe', [ParentController::class, 'sucKhoe'])->name('parent.suckhoe');
});

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
    // Duyệt thông báo
    Route::get('/thongbao', [DuyetThongBaoController::class, 'index'])->name('admin.thongbao.index');
    Route::get('/thongbao/history', [DuyetThongBaoController::class, 'history'])->name('admin.thongbao.history');
    Route::get('/thongbao/{id}', [DuyetThongBaoController::class, 'show'])->name('admin.thongbao.show');
    Route::post('/thongbao/{id}/approve', [DuyetThongBaoController::class, 'approve'])->name('admin.thongbao.approve');
    Route::post('/thongbao/{id}/reject', [DuyetThongBaoController::class, 'reject'])->name('admin.thongbao.reject');
});

Route::prefix('teacher')->middleware('teacher')->group(function () {

    Route::get('/', [TeacherController::class, 'index'])->name('teacher.teacher');
    Route::resource('hocsinh', QuanlyhocsinhController::class)->names('teacher.hocsinh');
    Route::resource('thongtincanhan', ThongtincanhanController::class)->names('teacher.thongtincanhan');
    Route::get('teacher/diemdanh', [DDlopController::class, 'index'])->name('teacher.diemdanh.index');
    Route::post('teacher/diemdanh', [DDlopController::class, 'store'])->name('teacher.diemdanh.store');
    Route::get('teacher/diemdanh/history', [DDlopController::class, 'history'])->name('teacher.diemdanh.history');
    Route::get('teacher/diemdanh/history-detail/{date}', [DDlopController::class, 'history_detail'])->name('teacher.diemdanh.history-detail');
    Route::resource('thongbao', ThongBaoController::class)->names('teacher.thongbao');
});
// Route::get('/teacher', function () {
//     return view('teacher.teacher');
// })->name('teacher.teacher');
// Route::get('/Teacher/chatbot', function () {
//     return view('Teacher.chatbot'); // tạo resources/views/chatbot.blade.php
// });
