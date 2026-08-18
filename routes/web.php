<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\BlogController as PublicBlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Guest Routes (Redirect authenticated admins to dashboard)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

        Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

        Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    // Admin Authenticated Routes
    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Category Management
        Route::resource('categories', AdminCategoryController::class);

        // Blog Management & CKEditor Image Upload
        Route::post('/blogs/upload-image', [AdminBlogController::class, 'uploadImage'])->name('blogs.upload-image');
        Route::resource('blogs', AdminBlogController::class);
    });
});
