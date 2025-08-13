<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Merlion\Addons\Auth\Http\Controllers\LoginController;

Route::get('login', [LoginController::class, 'showLogin'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'submitLogin'])->name('login.submit');
