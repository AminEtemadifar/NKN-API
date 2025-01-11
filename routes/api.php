<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TermController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {});
Route::apiResource('auth', AuthController::class)->only(['store']);
Route::apiResource('home', HomeController::class)->only(['index']);
Route::apiResource('doctors', DoctorController::class)->only(['index' , 'show']);
Route::group([
    'as' => 'api.',
    //'middleware' => ['auth:api']
], function () {
    Route::delete('auth', [AuthController::class , 'destroy']);
    Route::apiResource('auth', AuthController::class)->except(['store', 'show', 'destroy']);
    Route::apiResource('sliders', SliderController::class)->except(['store' , 'destroy']);
    Route::apiResource('slides', SlideController::class)->except(['index']);
    Route::apiResource('terms', TermController::class);
    Route::apiResource('hospitals', HospitalController::class);
});

