<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostAttachmentController;
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
| Post Special Actions (Bulk, Export, Status Toggle)
|--------------------------------------------------------------------------
*/

Route::post('/posts/bulk-action', [
    PostController::class,
    'bulkAction'
])->name('posts.bulkAction');

Route::get('/posts-export', [
    PostController::class,
    'export'
])->name('posts.export');

Route::patch('/posts/{post}/toggle-status', [
    PostController::class,
    'toggleStatus'
])->name('posts.toggleStatus');

/*
|--------------------------------------------------------------------------
| Post Attachments
|--------------------------------------------------------------------------
*/

Route::post('/posts/{post}/attachments', [
    PostAttachmentController::class,
    'store'
])->name('posts.attachments.store');

Route::delete('/attachments/{attachment}', [
    PostAttachmentController::class,
    'destroy'
])->name('attachments.destroy');

/*
|--------------------------------------------------------------------------
| Activity Logs
|--------------------------------------------------------------------------
*/

Route::get('/activities', [
    ActivityLogController::class,
    'index'
])->name('activities.index');

Route::delete('/activities/clear', [
    ActivityLogController::class,
    'clear'
])->name('activities.clear');

/*
|--------------------------------------------------------------------------
| Posts Resource
|--------------------------------------------------------------------------
*/

Route::resource('posts', PostController::class);

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});