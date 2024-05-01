<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name("user.index");
    Route::get('/show/{id}', [UserController::class, 'show'])->name("user.show");
    Route::post('/create', [UserController::class, 'create'])->name("user.create");
    Route::post('/signin', [UserController::class, 'signIn'])->name("user.signin");
    Route::post('/validateToken', [UserController::class, 'validateToken'])->name("user.validateToken");
    Route::put('/update/{id}', [UserController::class, 'update'])->name("user.update");
    Route::put('/update/password/{id}', [UserController::class, 'updatePassword'])->name("user.update.password");
    Route::delete('/remove/{id}', [UserController::class, 'remove'])->name("user.remove");
});

Route::prefix('category')->group(function () {
    Route::get('/index', [CategoryController::class, 'index'])->name("category.index");
    Route::get('/show/{id}', [CategoryController::class, 'show'])->name("category.show");
    Route::post('/create', [CategoryController::class, 'create'])->name("category.create");
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name("category.update");
    Route::delete('/remove/{id}', [CategoryController::class, 'remove'])->name("category.remove");
});

Route::prefix('post')->group(function () {
    Route::get('/index', [PostController::class, 'index'])->name("post.index");
    Route::get('/show/{id}', [PostController::class, 'show'])->name("post.show");
    Route::post('/create', [PostController::class, 'create'])->name("post.create");
    Route::put('/update/{id}', [PostController::class, 'update'])->name("post.update");
    Route::delete('/remove/{id}', [PostController::class, 'remove'])->name("post.remove");
    Route::post('/search', [PostController::class, 'search'])->name("post.search");
    Route::get('/downloadcsv/{id}', [PostController::class, 'downloadCsv'])->name("post.downloadcsv");
});

