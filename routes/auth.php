<?php

use Merlion\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'showLogin'])->name('login');
Route::post('login', [LoginController::class, 'submitLogin'])->name('login.submit');
