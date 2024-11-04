<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'v1',
    'as' => 'api.'
], function () {


    Route::group([
        'middleware' =>  ['auth:sanctum', 'verified'],
    ], function () {

        Route::apiResources([]);
    });
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
