<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResumeController;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\SeoController;

Route::middleware(TrackVisitor::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/resume', ResumeController::class)->name('resume.download');
});

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');
    
    // SEO
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

// Admin area
Route::prefix('admin')->group(function () {

    // Hanya untuk yang BELUM login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'create'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])
            ->middleware('throttle:login')
            ->name('login.store');
    });

        // Hanya untuk yang SUDAH login
        Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');
        Route::get('/messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
        Route::delete('/messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');

        Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');

        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
        Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
    });

});