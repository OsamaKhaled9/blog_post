<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/getauthors', [Controller::class, 'fetchAuthors']);

Route::get('/getarticles',[Controller::class, 'fetchArticles']);

Route::get('/getarticlebyauthor/{id}',[Controller::class, 'fetchArticleByAuthor']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favorites/add', [Controller::class, 'addToFavorites']);
    Route::delete('/favorites/remove', [Controller::class, 'removeFromFavorites']);
    Route::get('/favorites/get/{id}', [Controller::class, 'getFavorites']);
    Route::post('/reports', [Controller::class, 'reportAuthor']); // Route for reporting an author
});
