<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});

Route::apiResource('post', PostController::class)->middleware('auth:sanctum');

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('me', [UserController::class, 'me']);
    Route::get('profile/{id}', [UserController::class, 'profile']);

    Route::group(['prefix' => 'follower'], function () {
        Route::get('/', [UserController::class, 'followers']);
        Route::get('{id}', [UserController::class, 'followers']);
    });

    Route::group(['prefix' => 'following'], function () {
        Route::get('/', [UserController::class, 'following']);
        Route::get('{id}', [UserController::class, 'following']);
    });

    Route::post('follow/{id}', [UserController::class, 'follow']);
    Route::post('unfollow/{id}', [UserController::class, 'unfollow']);
});
