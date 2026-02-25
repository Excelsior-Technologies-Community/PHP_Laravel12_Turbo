<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Create all CRUD routes (index, create, store, show, edit, update, destroy) for posts
Route::resource('posts', PostController::class);

// Redirect homepage (/) to posts listing page
Route::get('/', fn () => redirect('/posts'));