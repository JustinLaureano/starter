<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/molds', function () {
    return response()->json([
        '100' => '100',
        '200' => '200',
        '300' => '300',
        '400' => '400',
        '500' => '500',
    ]);
})->middleware('auth:sanctum');

Route::get('/parts', function () {
    return response()->json([
        'dff',
        'dff',
        'dff',
        'dff',
        'dff',
        'dff',
        'dff',
        'dff',
    ]);
});


Route::get('/test', function () {
    return response()->json(['message' => 'Hello, world!']);
});
