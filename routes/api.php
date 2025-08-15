<?php

use Illuminate\Support\Facades\Route;
use Merlion\Http\Controllers\Api\FormSubmitController;
use Merlion\Http\Controllers\Api\LazyRenderController;

Route::group(['prefix' => 'merlion-api'], function () {
    Route::get('lazy-render', LazyRenderController::class);
    Route::post('form-submit', FormSubmitController::class);
});
