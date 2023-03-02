<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/', [\App\Http\Controllers\DashboardController::class, 'store'])->name('dashboard.store');
Route::delete('/{id}', [\App\Http\Controllers\DashboardController::class, 'delete'])->name('dashboard.delete');
