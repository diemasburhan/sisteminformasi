<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Site
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [HomeController::class, 'post'])->name('public.post.show');
Route::get('/berita', [HomeController::class, 'posts'])->name('public.posts');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('public.page.show');
Route::post('/post/{postId}/comment', [HomeController::class, 'comment'])->name('public.comment.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel (Protected by Auth Middleware)
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Posts CMS
    Route::post('/posts/bulk', [PostController::class, 'bulkAction'])->name('admin.posts.bulk');
    Route::post('/posts/autosave', [PostController::class, 'autoSave'])->name('admin.posts.autosave');
    Route::resource('posts', PostController::class, ['as' => 'admin'])->except(['show']);
    
    // Pages CMS
    Route::post('/pages/bulk', [PageController::class, 'bulkAction'])->name('admin.pages.bulk');
    Route::post('/pages/autosave', [PageController::class, 'autoSave'])->name('admin.pages.autosave');
    Route::resource('pages', PageController::class, ['as' => 'admin'])->except(['show']);
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
