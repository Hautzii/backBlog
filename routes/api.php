<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostController::class, 'getData']);
Route::get('/posts/{id}', [PostController::class, 'getDataByID']);
Route::get('/raw', [PostController::class, 'getRawData']);
Route::get('/raw/{id}', [PostController::class, 'getRawDataByID']);
Route::put('/posts/{id}', [PostController::class, 'update']);
