<?php

use Merlion\Http\Controllers\FormController;
use Merlion\Http\Controllers\LanguageController;
use Merlion\Http\Controllers\RenderController;

Route::any('__render/{data}', RenderController::class)->name('render');
Route::any('__form/{data}', FormController::class)->name('form.submit');
Route::any('__lang/{locale}', LanguageController::class)->name('lang');
