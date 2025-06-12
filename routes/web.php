<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/productos', [ProductController::class, 'index']);
Route::get('/productos/list', [ProductController::class, 'list']);
Route::post('/productos/store', [ProductController::class, 'store']);
Route::get('/productos/{id}', [ProductController::class, 'show']);
Route::post('/productos/update/{id}', [ProductController::class, 'update']);
Route::delete('/productos/delete/{id}', [ProductController::class, 'destroy']);
