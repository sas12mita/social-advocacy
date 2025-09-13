<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OurCampaignController;
use App\Http\Controllers\OurEventController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('fronend.pages.welcome');
});
Route::get('/admin/login', function () {
    return view('backend.admin.login');
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('campaigns', OurCampaignController::class);
    Route::resource('events', OurEventController::class);
    Route::post('/article/statusupdate/{id}', [ArticleController::class, 'statusupdate'])->name('articles.statusupdate');
});



Route::get('login', [AdminController::class, 'login_view'])->name('admin.login');
Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
