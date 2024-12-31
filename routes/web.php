<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(
    function () {
        Route::get('/', [AuthController::class, "ShowLoginForm"])->name("login");
        Route::post('/', [AuthController::class, "login"]);
    }
);


Route::middleware('auth')->group(
    function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('can:manageUser')->group(
            function () {
                Route::get('/users', [UserController::class, 'index'])->name("users.index");
                Route::get('/add_user', [UserController::class, "create"])->name("user.create");
                Route::post("/add_user", [UserController::class, "store"])->name("user.store");
                Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::put('/update_user/{id}', [UserController::class, 'update'])->name('user.update');
                Route::delete('/users/{id}', [UserController::class, "destroy"])->name("user.destroy");
                /* ______________________________________________________________________________ */
                Route::get('/categories', [CategoryController::class, 'index'])->name("categories.index");
                Route::get('/add_category', [categoryController::class, "create"])->name("category.create");
                Route::post("/add_category", [categoryController::class, "store"])->name("category.store");
                Route::get('/edit_category/{id}', [categoryController::class, 'edit'])->name('category.edit');
                Route::put('/update_category/{id}', [categoryController::class, 'update'])->name('category.update');
                Route::delete('/categories/{id}', [categoryController::class, "destroy"])->name("category.destroy");
                /* ______________________________________________________________________________ */
                Route::get('/tags', [TagController::class, 'index'])->name("tags.index");
                Route::get('/add_tag', [TagController::class, "create"])->name("tag.create");
                Route::post("/add_tag", [TagController::class, "store"])->name("tag.store");
                Route::get('/edit_tag/{id}', [TagController::class, 'edit'])->name('tag.edit');
                Route::put('/update_tag/{id}', [tagController::class, 'update'])->name('tag.update');
                Route::delete('/tags/{id}', [TagController::class, "destroy"])->name("tag.destroy");
            }
        );
        Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
        /* ______________________________________________________________________________ */
        Route::get('/edit_post/{id}', [postController::class, 'edit'])->name('post.edit');
        Route::put('/update_post/{id}', [postController::class, 'update'])->name('post.update');
        Route::delete('/posts/{id}', [postController::class, "destroy"])->name("post.destroy");
        /* ______________________________________________________________________________ */

        Route::get('/posts', [PostController::class, 'index'])->name("posts.index");
        Route::get('/add_post', [postController::class, "create"])->name("post.create");
        Route::post("/add_post", [postController::class, "store"])->name("post.store");
        Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
        /* ______________________________________________________________________________ */
        
        
        Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comment.store');
        Route::get('/posts/{post}/comments/{id}/edit', [CommentController::class, 'edit'])->name('comment.edit');
        Route::put('/posts/{post}/comments/{id}', [CommentController::class, 'update'])->name('comment.update');
        Route::delete('/posts/{post}/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    }
);
