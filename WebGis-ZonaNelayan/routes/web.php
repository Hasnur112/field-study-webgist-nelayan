<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebGisController;

Route::get('/', [WebGisController::class, 'beranda']);
Route::get('/peta', [WebGisController::class, 'index']);
Route::post('/lapor', [WebGisController::class, 'store']);
