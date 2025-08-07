<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->get('/alumno', function (Request $request) {
        return $request->user()->alumno;
    });
