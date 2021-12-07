<?php

namespace App\Http\Controllers;
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

Route::get('/', HomeController::class)->name('home');
Route::get('/user', function () {return response()->json(['token' => csrf_token()]);})->middleware(['auth'])->name('user');
Route::get('/favorites', FavoriteController::class)->middleware(['auth'])->name('favorites.index');
Route::get('/characters/favorites', [CharacterController::class, 'favorites'])->middleware(['auth'])->name('characters.favorite');
Route::resource('characters', CharacterController::class)->only(['index', 'show', 'update', 'destroy']);
Route::get('/comics/favorites', [ComicController::class, 'favorites'])->middleware(['auth'])->name('comics.favorite');
Route::resource('comics', ComicController::class)->only(['index', 'show', 'update', 'destroy']);

require __DIR__.'/auth.php';
