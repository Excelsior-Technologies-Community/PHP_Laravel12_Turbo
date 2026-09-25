<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [
    DashboardController::class,
    'index'
])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Post Bulk Actions
|--------------------------------------------------------------------------
*/

Route::post('/posts/bulk-action', [
    PostController::class,
    'bulkAction'
])->name('posts.bulkAction');

/*
|--------------------------------------------------------------------------
| Post CSV Export
|--------------------------------------------------------------------------
*/

Route::get('/posts-export', [
    PostController::class,
    'export'
])->name('posts.export');

/*
|--------------------------------------------------------------------------
| Posts
|--------------------------------------------------------------------------
*/

Route::resource(
    'posts',
    PostController::class
);

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});