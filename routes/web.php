<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified', 'role.redirect'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:admin,superadmin')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/category', [ProductCategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [ProductCategoryController::class, 'create'])->name('category.create');
        Route::post('/category', [ProductCategoryController::class, 'store'])->name('category.store');

        Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');

});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:superadmin')
    ->group(function () {
        Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
//        Route::post('/roles', [ProductCategoryController::class, 'store'])->name('category.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
