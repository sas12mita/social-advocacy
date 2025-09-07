<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;



Route::get('/', function () {
    return view('fronend.pages.welcome');
});
Route::get('/admin/login', function () {
    return view('backend.admin.login');
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
});


Route::get('login', [AdminController::class, 'login_view'])->name('admin.login');
Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
