<?php

use Merlion\Http\Controllers\Auth\HomeController;
use Merlion\Http\Controllers\Auth\LoginController;
use Merlion\Http\Middleware\Authenticate;

Route::get('login', [LoginController::class, 'showLogin'])->name('login');
Route::post('login', [LoginController::class, 'submitLogin'])->name('login.submit');
Route::group(['middleware' => Authenticate::class], function () {
    Route::get('/', HomeController::class)->name('home');
    Route::any('logout', [LoginController::class, 'logout'])->name('logout');
});
