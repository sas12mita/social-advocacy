<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OurCampaignController;
use App\Http\Controllers\OurEventController;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'index'])->name('index');

Route::get('/admin/login', function () {
    return view('backend.admin.login');
});

Route::post('/events/register', [EventRegistrationController::class, 'register'])->name('events.register');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::post('/article/statusupdate/{id}', [ArticleController::class, 'statusupdate'])->name('articles.statusupdate');

    Route::resource('campaigns', OurCampaignController::class);
    Route::post('/campaigns/statusupdate/{id}', [OurCampaignController::class, 'statusupdate'])->name('campaigns.statusupdate');

    Route::resource('events', OurEventController::class);
    Route::post('/events/statusupdate/{id}', [OurEventController::class, 'statusupdate'])->name('events.statusupdate');

    Route::get('/events/{id}/register', [EventRegistrationController::class, 'eventregistered'])->name('events.registerviewall');
});



Route::get('login', [AdminController::class, 'login_view'])->name('admin.login');
Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
