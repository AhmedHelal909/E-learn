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


Route::group(['middleware' => 'auth:api', 'namespace' => 'Api',], function () {

    Route::get('this', function () {
        return 'thisiisiisiis';
    });



    Route::post('logout', 'CategoryController@logoutApi'); // this is for logout

});

Route::group(['namespace' => 'Api', 'middleware' => 'guest:api'], function () {

    Route::resource('categories', 'CategoryController');
});
