<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebGisController;

Route::get('/', [WebGisController::class, 'beranda'])->name('beranda');
Route::get('/peta', [WebGisController::class, 'index'])->name('peta');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [WebGisController::class, 'dashboard'])->name('dashboard');
    Route::post('/lapor', [WebGisController::class, 'store'])->name('lapor.store');
    Route::put('/lapor/{id}', [WebGisController::class, 'update'])->name('lapor.update');
    Route::delete('/lapor/{id}', [WebGisController::class, 'destroy'])->name('lapor.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
