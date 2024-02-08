<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::group(['middleware' => 'guest'], function () {

    Route::post('/logout', [UserController::class, 'destroy']);
    Route::get('/register', [UserController::class, 'showRegisterForm']);
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/logout', [UserController::class, 'destroy']);
    Route::post('/login', [UserController::class, 'authenticate']);
    Route::post('/register', [UserController::class, 'store']);

});

