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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group(function () {
    Route::namespace('Api')->group(function () {
        //access without authenticated users
        Route::post('/login','Auth\AuthController@login')->name('login');
        Route::post('/signup','Auth\AuthController@register');
       
        //access with authenticated users only
        Route::middleware('auth:api')->group(function () {
            Route::post('/logout','Auth\AuthController@logout');
            Route::resource('notes','NoteController');

            Route::get('user/profile','UserController@index');
            Route::get('notes/all','UserController@index');
        });
    });
});
   

   

