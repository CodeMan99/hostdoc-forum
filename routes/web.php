<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');


// Route::get('test', function() {
//     $user = \App\Models\User::find(12);
//     $user_res = \App\Http\Resources\UserResource::make($user);

//     $post = \App\Models\Post::find(1);
//     $post_res = \App\Http\Resources\PostResource::make($post);

//     $comment = \App\Models\Comment::find(1);
//     $comment_res = \App\Http\Resources\CommentResource::make($comment);

//     return [
//         'user' => $user_res,
//         'post' => $post_res,
//         'comment' => $comment_res,
//     ];
// });
