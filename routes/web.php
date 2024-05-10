<?php

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/show-blog/{id}', [HomeController::class, 'showBlog'])->name('show.blog');

Route::get('/dashboard', function () {
    $blogs = Blog::with('category')->where('user_id', Auth::user()->id)->latest()->paginate(10);
    return view('dashboard', ['blogs' => $blogs]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/blogs', BlogController::class);
    Route::resource('/categories', CategoryController::class);
});

require __DIR__ . '/auth.php';
