<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

if(config('app.env') == 'local'){
    Route::post('v1/user/token', function (Request $request) {

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return response()->json([
                'status' => '401',
                'error' => 'Unauthorized'
            ], 401);
        }

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => '401',
                'error' => 'Unauthorized'
            ], 401);
        }

        return [
            'token' => explode( '|', $user->createToken('api')->plainTextToken )[1],
            'user' => $user
        ];
    })->middleware(['json','api']);
}


Route::group([
        'middleware' => [ 'json', 'auth:sanctum' ],
        'prefix' => 'v1',
        'namespace' => 'App\Http\Controllers\Api\v1'

    ], function () {

        // test auth sanctum
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // {{url}}/api/v1/templates/
        Route::resource('checklists/templates', 'TemplateController');

        Route::resource('checklists', 'ChecklistController');

        Route::resource('checklists/{id}/items', 'ItemController');

});
