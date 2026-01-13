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
use App\Http\Controllers\Teacher\HoatDongController;
use App\Http\Controllers\Teacher\ChatController as TeacherChatController;
use App\Http\Controllers\Teacher\XuatFileController;
use App\Http\Controllers\Teacher\HocPhiController as TeacherHocPhiController;
use App\Http\Controllers\Teacher\DanhGiaController as TeacherDanhGiaController;
use App\Http\Controllers\User\ParentController;
use App\Http\Controllers\User\ChatController as ParentChatController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;

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
    Route::get('/hoat-dong', [ParentController::class, 'hoatDong'])->name('parent.hoatdong');
    Route::get('/thongbaodetail/{id}', [HomeController::class, 'thongbao_detail'])->name('parent.thongbaodetail');

    // Chat routes cho phụ huynh
    Route::get('/chat/teachers', [ParentChatController::class, 'getTeachers'])->name('parent.chat.teachers');
    Route::get('/chat/messages/{giaoVienId}', [ParentChatController::class, 'getMessages'])->name('parent.chat.messages');
    Route::post('/chat/send', [ParentChatController::class, 'sendMessage'])->name('parent.chat.send');
    Route::get('/chat/check-new/{giaoVienId}', [ParentChatController::class, 'checkNewMessages'])->name('parent.chat.check-new');
    Route::get('/chat/check-read/{giaoVienId}', [ParentChatController::class, 'checkReadStatus'])->name('parent.chat.check-read');
    Route::get('/chat/unread-count', [ParentChatController::class, 'getUnreadCount'])->name('parent.chat.unread-count');
    Route::get('/chat/conversations', [ParentChatController::class, 'getConversations'])->name('parent.chat.conversations');
});

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/welcome', [AdminController::class, 'index'])->name('admin.welcome');
    Route::resource('lophoc', LopHocController::class)->names('admin.lophoc');
    Route::resource('giaovien', GiaoVienController::class)->names('admin.giaovien');
    Route::resource('nguoidung', UserController::class)->names('admin.nguoidung');
    Route::post('/nguoidung/{id}/lock', [UserController::class, 'lock'])->name('admin.nguoidung.lock');
    Route::post('/nguoidung/{id}/unlock', [UserController::class, 'unlock'])->name('admin.nguoidung.unlock');
    Route::resource('phuhuynh', PhuHuynhController::class)->names('admin.phuhuynh');
    Route::resource('hocsinh', HocSinhController::class)->names('admin.hocsinh');
    Route::resource('diemdanh', DiemDanhController::class)->names('admin.diemdanh');
    Route::get('admin/diemdanh/{id}', [DiemDanhController::class, 'show'])->name('admin.diemdanh.show');
    // Đánh giá
    Route::resource('danhgia', DanhGiaController::class)->names('admin.danhgia');
    //sức khỏe
    Route::resource('suckhoe', SucKhoeController::class)->names('admin.suckhoe');
    //học phí
    Route::get('hocphi/get-so-ngay-di-hoc', [HocPhiController::class, 'getSoNgayDiHoc'])->name('admin.hocphi.getSoNgayDiHoc');
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

    // Quản lý học phí
    Route::get('hocphi/get-so-ngay-di-hoc', [TeacherHocPhiController::class, 'getSoNgayDiHoc'])->name('teacher.hocphi.getSoNgayDiHoc');
    Route::resource('hocphi', TeacherHocPhiController::class)->names('teacher.hocphi');

    // Quản lý đánh giá
    Route::resource('danhgia', TeacherDanhGiaController::class)->names('teacher.danhgia');

    Route::get('teacher/diemdanh', [DDlopController::class, 'index'])->name('teacher.diemdanh.index');
    Route::post('teacher/diemdanh', [DDlopController::class, 'store'])->name('teacher.diemdanh.store');
    Route::get('teacher/diemdanh/history', [DDlopController::class, 'history'])->name('teacher.diemdanh.history');
    Route::get('teacher/diemdanh/history-detail/{date}', [DDlopController::class, 'history_detail'])->name('teacher.diemdanh.history-detail');
    Route::get('teacher/diemdanh/edit/{date}', [DDlopController::class, 'edit'])->name('teacher.diemdanh.edit');
    Route::post('teacher/diemdanh/update/{date}', [DDlopController::class, 'update'])->name('teacher.diemdanh.update');
    Route::resource('thongbao', ThongBaoController::class)->names('teacher.thongbao');

    // Hoạt động hàng ngày routes
    Route::get('/hoatdong', [HoatDongController::class, 'index'])->name('teacher.hoatdong.index');
    Route::get('/hoatdong/create', [HoatDongController::class, 'create'])->name('teacher.hoatdong.create');
    Route::post('/hoatdong', [HoatDongController::class, 'store'])->name('teacher.hoatdong.store');
    Route::get('/hoatdong/{id}', [HoatDongController::class, 'show'])->name('teacher.hoatdong.show');
    Route::delete('/hoatdong/{id}', [HoatDongController::class, 'destroy'])->name('teacher.hoatdong.destroy');
    Route::post('/hoatdong/dang-nhanh', [HoatDongController::class, 'dangNhanhAnh'])->name('teacher.hoatdong.dang-nhanh');

    // Chat routes cho giáo viên
    Route::get('/chat', [TeacherChatController::class, 'index'])->name('teacher.chat.index');
    Route::get('/chat/messages/{phuHuynhId}', [TeacherChatController::class, 'getMessages'])->name('teacher.chat.messages');
    Route::post('/chat/send', [TeacherChatController::class, 'sendMessage'])->name('teacher.chat.send');
    Route::get('/chat/check-new/{phuHuynhId}', [TeacherChatController::class, 'checkNewMessages'])->name('teacher.chat.check-new');
    Route::get('/chat/check-read/{phuHuynhId}', [TeacherChatController::class, 'checkReadStatus'])->name('teacher.chat.check-read');
    Route::get('/chat/unread-count', [TeacherChatController::class, 'getUnreadCount'])->name('teacher.chat.unread-count');
    Route::get('/chat/conversations', [TeacherChatController::class, 'getConversations'])->name('teacher.chat.conversations');

    // Xuất file PDF routes
    Route::get('/xuatfile', [XuatFileController::class, 'index'])->name('teacher.xuatfile.index');
    Route::get('/xuatfile/hocphi/{id}', [XuatFileController::class, 'xuatHocPhiHocSinh'])->name('teacher.xuatfile.hocphi');
    Route::get('/xuatfile/hocphi-lop', [XuatFileController::class, 'xuatHocPhiLop'])->name('teacher.xuatfile.hocphi-lop');
    Route::get('/xuatfile/danhgia/{id}', [XuatFileController::class, 'xuatDanhGiaHocSinh'])->name('teacher.xuatfile.danhgia');
    Route::get('/xuatfile/danhgia-lop', [XuatFileController::class, 'xuatDanhGiaLop'])->name('teacher.xuatfile.danhgia-lop');
    Route::get('/xuatfile/xemtruoc-hocphi/{id}', [XuatFileController::class, 'xemTruocHocPhi'])->name('teacher.xuatfile.xemtruoc-hocphi');
    Route::get('/xuatfile/xemtruoc-danhgia/{id}', [XuatFileController::class, 'xemTruocDanhGia'])->name('teacher.xuatfile.xemtruoc-danhgia');
});
// Route::get('/teacher', function () {
//     return view('teacher.teacher');
// })->name('teacher.teacher');
// Route::get('/Teacher/chatbot', function () {
//     return view('Teacher.chatbot'); // tạo resources/views/chatbot.blade.php
// });
