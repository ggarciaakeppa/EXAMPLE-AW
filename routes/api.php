<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UsersApiController;

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

/* Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
}); */

Route::controller(UsersApiController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');  
});

Route::middleware('auth:sanctum')->controller(UsersApiController::class)->group(function(){  
    Route::get('logout', 'logout');
    Route::get('user', 'user');
    Route::post('user/update/profile/photo', 'updateProfilePhoto');
    Route::put('user/update/profile', 'updateProfile');
    Route::post('user/update/password', 'updatePassword');  
    Route::post('forgot-password','restorePassword');
    Route::delete('user', 'deleteUser');
    Route::get('user/sessions','getSessions');
    Route::delete('user/sessions/{id}','deleteSession');
});
