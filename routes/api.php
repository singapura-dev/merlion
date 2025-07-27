<?php

use Merlion\Http\Controllers\FormController;
use Merlion\Http\Controllers\LanguageController;
use Merlion\Http\Controllers\RenderController;
use Merlion\Http\Controllers\UploadController;

Route::any('render/{data}', RenderController::class)->name('render');
Route::any('form/{data}', FormController::class)->name('form.submit');
Route::any('lang/{locale}', LanguageController::class)->name('lang');
Route::any('upload', UploadController::class)->name('upload');

