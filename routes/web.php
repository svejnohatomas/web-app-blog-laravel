<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TODO: Add route constraints
Route::controller(CategoryController::class)->group(function () {
    // Create
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('category.store');

    // Read
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('category.show');

    // Update
    Route::get('/categories/edit/{slug}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categories/edit/{id}', [CategoryController::class, 'update'])->name('category.update')->whereNumber('id');

    // Delete
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy')->whereNumber('id');
});

// TODO: Add route constraints
Route::controller(PostController::class)->group(function () {
    // Create
    Route::get('/categories/{categorySlug}/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts/create', [PostController::class, 'store'])->name('post.store');

    // Read
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('post.show');

    // Update
    Route::get('/posts/edit/{slug}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/posts/edit/{id}', [PostController::class, 'update'])->name('post.update')->whereNumber('id');

    // Delete
    Route::delete('/posts/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy')->whereNumber('id');
});

Route::controller(CommentController::class)->group(function () {
    // Create
    Route::post('/comments/create', [CommentController::class, 'store'])->name('comment.store');

    // Read - none needed

    // Update
    Route::get('/comments/edit/{id}', [CommentController::class, 'edit'])->name('comment.edit')->whereNumber('id');
    Route::put('/comments/edit/{id}', [CommentController::class, 'update'])->name('comment.update')->whereNumber('id');

    // Delete
    Route::delete('/comments/delete/{id}', [CommentController::class, 'destroy'])->name('comment.destroy')->whereNumber('id');
});

require __DIR__.'/auth.php';
