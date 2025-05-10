<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::resource('users', UserController::class)->except(['show']);
});

//Rutas a los controladores
Route::resource('jobs', JobController::class);
Route::resource('materials', MaterialController::class);
Route::resource('stock-movements', StockMovementController::class);
Route::get('/stock-movements-log', [StockMovementController::class, 'viewLog'])->name('stock.movements.log');
Route::post('/jobs/{id}/update-status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
