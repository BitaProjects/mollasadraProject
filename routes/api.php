<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
//    Route::post('/login', 'Api\V1\apiController@login');
    Route::post('/register', 'Api\V1\ApiController@register');
    Route::post('/verify', 'Api\v1\ApiController@verify');
});
Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/userInfo','Api\V1\ApiController@info');
});
