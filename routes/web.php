<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LopHocController;

Route::get('/', function () {
    return view('admin.welcome');
}) ->name('admin.welcome');
//Route::resource('lophoc', LopHocController::class);
Route::get('/lophoc', [LopHocController::class, 'index'])->name('lophoc.index');
 Route::get('lophoc/create', [LopHocController::class, 'create'])->name('lophoc.create');
    Route::post('lophoc/store', [LopHocController::class, 'store'])->name('lophoc.store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
