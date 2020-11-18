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

Route::group([
        'middleware' => [ 'json', 'auth:sanctum' ],
        'prefix' => 'v1',
        'namespace' => 'Api\v1'
    ], function () {

        // test auth sanctum
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // {{url}}/api/v1/templates/
        Route::group(['prefix' => 'checklists'], function () {
            Route::resource('templates', 'TemplateController');

        });

});
