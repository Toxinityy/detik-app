<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\HomeController;
use App\http\Controllers\MainController;
use App\http\Controllers\LoginController;

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

Auth::routes();
Route::get("/login", [MainController::class, "show_login"])->name("login");
Route::post("/login", [MainController::class, "login"]);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', [HomeController::class, 'index']);

Route::get('/kategori', [CategoryController::class, 'index']);
Route::post('/kategori', [CategoryController::class, 'store'])->name('category.store');
Route::put('/kategori', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/kategori/', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('/buku', [BookController::class, 'index']);
Route::post('/buku', [BookController::class, 'store'])->name('book.store');
Route::put('/buku', [BookController::class, 'update'])->name('book.update');
Route::delete('/buku', [BookController::class, 'delete'])->name('book.delete');

