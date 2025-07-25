<?php

use Merlion\Http\Controllers\FormController;
use Merlion\Http\Controllers\LanguageController;
use Merlion\Http\Controllers\RenderController;

Route::any('render/{data}', RenderController::class)->name('render');
Route::any('form/{data}', FormController::class)->name('form.submit');
Route::any('lang/{locale}', LanguageController::class)->name('lang');
