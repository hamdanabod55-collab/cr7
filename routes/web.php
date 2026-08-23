<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/items', [DashboardController::class, 'store'])->name('items.store');
Route::patch('/items/{id}', [DashboardController::class, 'update'])->name('items.update');
Route::delete('/items/{id}', [DashboardController::class, 'destroy'])->name('items.destroy');
Route::get('/db-check', [DashboardController::class, 'dbCheck'])->name('db.check');
