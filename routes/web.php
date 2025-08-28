<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('fronend.pages.welcome');
});
Route::get('/admin/login', function () {
    return view('backend.admin.login');
});
Route::get('/admin/dashbaord', function () {
    return view('backend.admin.dashboard');
})->name('admin.dashboard');
Route::get('login', [AdminController::class, 'login_view'])->name('admin.login');
Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
