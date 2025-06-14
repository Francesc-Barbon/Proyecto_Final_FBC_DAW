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
Route::get('/materials/create/{job?}', [MaterialController::class, 'create'])->name('materials.create');
Route::get('/jobs/{job}/add-material', [JobController::class, 'addMaterial'])->name('jobs.addMaterial');
Route::post('/jobs/{id}/add-material', [JobController::class, 'addMaterial'])->name('jobs.addMaterial');
Route::post('/jobs/{job}/add-hours', [JobController::class, 'addHours'])->name('jobs.addHours');
Route::put('/jobs/{job}/materials/{movement}', [JobController::class, 'updateMaterial'])->name('jobs.updateMaterial');
Route::put('/jobs/{job}/hours/{hour}', [JobController::class, 'updateHour'])->name('jobs.updateHour');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
