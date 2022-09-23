<?php

use App\Http\Controllers\Admin\User\AdminsController;
use App\Http\Controllers\Admin\Work_with\DataBaseController;
use App\Http\Controllers\Admin\Work_with\FrameworkController;
use App\Http\Controllers\Admin\Work_with\HostingController;
use App\Http\Controllers\Admin\Work_with\LanguageController;
use App\Http\Controllers\Admin\Work_with\PackageController;
use App\Http\Controllers\Admin\Work_with\RestApiController;
use App\Http\Controllers\Admin\Work_with\ToolsController;
use App\Http\Controllers\Admin\Work_with\VersioningController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Dashboard\DashboardController;





Route::prefix('admin')->as('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ADMIN
    Route::resource('admins', AdminsController::class);

    // Work With
    Route::resource('language', LanguageController::class);
    Route::resource('framework', FrameworkController::class);
    Route::resource('database', DataBaseController::class);
    Route::resource('hosting', HostingController::class);
    Route::resource('rest-api', RestApiController::class);
    Route::resource('package', PackageController::class);
    Route::resource('versioning', VersioningController::class);
    Route::resource('tools', ToolsController::class);
});
