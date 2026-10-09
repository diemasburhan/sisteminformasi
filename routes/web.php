<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\OrgMemberController;
use App\Http\Controllers\Admin\ExpertiseController;
use App\Http\Controllers\Admin\GalleryController;
use App\Models\Gallery;

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
Route::post('/faq/submit', [\App\Http\Controllers\FaqController::class, 'submit'])->name('public.faq.submit')->middleware('throttle:10,1');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel (Protected by Auth + Admin Role Middleware)
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
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
    
    // Lecturers CMS
    Route::resource('lecturers', LecturerController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('expertises', ExpertiseController::class, ['as' => 'admin'])->except(['show']);

    // Org Members CMS
    Route::resource('org-members', OrgMemberController::class, ['as' => 'admin'])->except(['show']);

    // SI Galeri CMS
    Route::resource('galleries', GalleryController::class, [
    'as' => 'admin'
    ])->except(['show']);

    // Pertanyaan FAQ CMS

    // Export semua data FAQ ke Excel
    Route::get('/faq-questions/export', [
    \App\Http\Controllers\Admin\FaqQuestionController::class,
    'export'
    ])->name('admin.faq-questions.export');

    Route::resource('faq-questions', \App\Http\Controllers\Admin\FaqQuestionController::class, [
    'as' => 'admin'
    ])->only(['index', 'show', 'update', 'destroy']);
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

});

// ==========================================
// PUBLIC - SI GALERI
// ==========================================

Route::get('/si.galeri', function () {

    $query = Gallery::where('status', 'published');

    // Filter berdasarkan kategori
    if (request()->filled('category')) {
        $query->where('category', request('category'));
    }

    $galleries = $query
        ->latest()
        ->get();

    // Daftar kategori SI Galeri
    $categories = [
        'Kegiatan SI',
        'HIMA SI',
        'Kampus',
        'Santai',
        'Cerita Mahasiswa',
    ];

    return view(
        'public.si-galeri',
        compact('galleries', 'categories')
    );

})->name('si.galeri');