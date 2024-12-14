<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {});
Route::apiResource('auth', AuthController::class)->except(['show' ]);

Route::group([
    'as' => 'api.',
    'middleware' => ['auth:api']
], function () {
    Route::apiResource('sliders', SliderController::class)->except(['store' , 'destroy']);
    Route::apiResource('slides', SlideController::class)->except(['index']);
});

