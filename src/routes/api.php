<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);
Route::post('password/email', [ResetPasswordController::class,'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class,'reset']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('dashboard', [AuthController::class,'dashboard'])->name('dashboard');
    Route::apiResource('posts', PostController::class)->except(['create','show',]);
});
