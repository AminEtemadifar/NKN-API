<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {});

Route::apiResource('auth', AuthController::class)->except(['show' ]);
Route::apiResource('sliders', SliderController::class)->except(['store' , 'destroy']);
