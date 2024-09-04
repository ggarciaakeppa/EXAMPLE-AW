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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

/* Route::post('/register', function (Request $request) {
    return response()->json(['status' => true]);
}); */
/* tramiteapp
Route::controller(UsersApiController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('user/expediente/image/{uri}', 'getExpedienteImage');
    Route::get('user/solicitud/image/{uri}', 'getSolicitudImage');
});

Route::middleware('auth:sanctum')->controller(UsersApiController::class)->group(function(){
    Route::get('logout', 'logout');
    Route::get('user', 'user');
    Route::post('user/update/profile/photo', 'updateProfilePhoto');
    Route::post('user/update/profile', 'updateProfile');
    Route::post('user/update/password', 'updatePassword');
    Route::post('user/add/expediente', 'addExpediente');
    Route::post('user/delete/expediente', 'deleteExpediente');
    Route::get('user/get/tipos/expediente', 'getExpedienteTipo');
    Route::get('user/expediente', 'getExpediente');
    Route::post('user/espediente/photo', 'uploadExpedientePhoto');
    Route::post('user/delete/espediente/photo', 'deleteExpedientePhoto');

    Route::post('user/solicitud/file', 'uploadFileSolicitud');
    Route::post('user/delete/solicitud/file', 'deleteFileSolicitud');

    Route::post('solicitud/add', 'addSolicitud');
    Route::post('solicitud/update/{id}', 'updateSolicitud');
    Route::post('solicitud/comentario/add', 'addComentario');
    Route::get('solicitud/get/solicitudes', 'getSolicitudes');

    Route::get('solicitud/get/{id}/data', 'getDataSolicitud');

    Route::get('noticias', 'getNoticias');
}); */
 
/* Route::post('/register', [UsersApiController::class, 'register'])->name('api.register');
Route::post('/login', [UsersApiController::class, 'login'])->name('api.login');
Route::post('/logout', [UsersApiController::class, 'logout'])->name('api.logout'); */