<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('welcome');
})->name('index');


Route::name('auth.')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/register',[UserController::class,'registerPage'])->name('register.page');
        Route::post('/register',[UserController::class,'register'])->name('register');

        Route::get('/login',[UserController::class,'loginPage'])->name('login.page');
        Route::post('/login',[UserController::class,'login'])->name('login');
    });

    Route::post('/logout',[UserController::class,'logout'])->name('logout')->middleware('auth');
});

Route::name('books.')->middleware('auth')->group(function(){
    Route::get('/',[BookController::class,'booksPage'])->name('index');

    Route::get('/library',[BookController::class,'userBooksPage'])->name('user');
    Route::get('/library/favorite',[BookController::class,'favoriteUserBooksPage'])->name('user.favorite');
    Route::get('/library/{uuid}',[BookController::class,'bookPage'])->name('book');

    Route::post('/books/add',[BookController::class,'addBookToUser'])->name('add');
    Route::post('/books/remove',[BookController::class,'removeBookFromUser'])->name('remove');

    Route::post('/books/favorite/add',[BookController::class,'addFavoriteBookToUser'])->name('favorite.add');
    Route::post('/books/favorite/remove',[BookController::class,'removeFavoriteBookFromUser'])->name('favorite.remove');
});
