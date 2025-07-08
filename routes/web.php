<?php

use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:admin,superadmin')
    ->group(function () {
        Route::get('/category', [ProductCategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [ProductCategoryController::class, 'create'])->name('category.create');
        Route::post('/category', [ProductCategoryController::class, 'store'])->name('category.store');
    });

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
