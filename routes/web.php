<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\VocabularyController;
use App\Http\Middleware\Authenticate;
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

Route::get('/login', [GoogleController::class, 'redirectToGoogle'])->name('login');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware([Authenticate::class])->group(function () {
    Route::get('/', [VocabularyController::class, 'home'])->name('home');
    Route::get('/vocab/get/{word}/', [VocabularyController::class, 'fetchWord'])->name('word.find');
    Route::get('/favorite', [VocabularyController::class, 'favorite'])->name('favorite');
    Route::get('/vocab/get/fav/{word}/', [VocabularyController::class, 'fetchFav'])->name('word.find.fav');
    Route::get('/vocab/change/fav/{id}/{status}', [VocabularyController::class, 'changeFav'])->name('word.change.fav');
    Route::get('/flash', [VocabularyController::class, 'flash'])->name('flash');
    Route::get('/manage', [VocabularyController::class, 'manage'])->name('manage');
    Route::get('/manage/delete/{word}', [VocabularyController::class, 'delete'])->name("word.delete");
    Route::post('/vocab/edit/save/', [VocabularyController::class, 'saveEdit'])->name("word.edit.save");
    Route::get('/voacb/json/{id}', [VocabularyController::class, 'fetchJson']);
    Route::post('/vocab/add/save/', [VocabularyController::class, 'addWord'])->name("word.add.save");
});
