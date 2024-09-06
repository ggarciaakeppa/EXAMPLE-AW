<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomUserProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Livewire\Ingreso\IngresoAuto;
use App\Mail\RestorePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    // Obtener el usuario como instancia del modelo User
    $user = User::where('email', $request->email)->first();

    if (!$user || $user->status == 0) {
        return back()->withErrors(['email' => "Correo no encontrado en nuestros registros"]);
    }

    // Envía el correo de restablecimiento de contraseña
    Mail::to($request->email)->send(new RestorePassword($user));

    // Vuelve a la misma página con un mensaje de éxito
    return back()->with('status', 'Correo de recuperación enviado correctamente.');
})->middleware('guest')->name('password.email');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session')
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user/profile/security', [CustomUserProfileController::class, 'show'])->name('profile.security');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session')
])->group(function () {
    Route::resource('users', UsersController::class);
    Route::get('/dashboard', function () {
   
        return view('dashboard');
    })->name('dashboard');   
});
