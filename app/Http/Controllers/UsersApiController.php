<?php

namespace App\Http\Controllers;

use App\Mail\RestorePassword;
use App\Models\User;
use App\Models\Expediente;
use App\Models\Solicitud;
use App\Models\Solicitud_status;
use App\Models\Solicitud_comentarios;
use App\Models\Noticias;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
/* use Illuminate\Validation\Rules\Password; */

class UsersApiController extends Controller
{

    public function messages()
    {
        return [
            'name.required' => 'El nombre no puede ir vacio.',
            'last_name.required' => 'Los apellidos no pueden ir vacios.',
            'phone.required' => 'Deberia haber un medio de contacto',
            'email.required' => 'El correo no puede ir vacio.',
            'email.email' => 'El formato de correo no es valido',
            'email.unique' => 'El correo ya esta en uso',
            'photo.max' => 'La fotografia pesa demasiado',
            'mimes:jpg,jpeg,png' => 'Solo se aceptan formatos jpg, jpeg y png',
        ];
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'status' => 1,
            'password' => Hash::make($request['password']),
        ]);

       // Se vera a futuro si es necesario mandar token al registrar
        // $token =  $user->createToken('api')->plainTextToken;

        return response()->json(['status' => true,'message' => 'Usuario registrado con exito!',]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'errors' => 'Las credenciales son incorrectas.']);
        }
     
        $token =  $user->createToken('api')->plainTextToken;

        return response()->json(['status' => true, 'token' => $token]);
    }

    function logout(Request $request) {
       
        $user = $request->user();

        $user->tokens()->delete();
        
        return response()->json(['status' => true],201);
        
    }

    function user(Request $request) {
        $user = $request->user();
        return $user;
    }

    function updateProfile(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'phone' => ['max:255'],
            'email' => ['email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        $message = "";

        if ($request['name']) {
            $user->name = $request['name'];
            $message = 'Nombre actualizado con exito!';
        }

        if ($request['last_name']) {
            $user->last_name = $request['last_name'];
            $message = 'Nombre actualizado con exito!';
        }

        if ($request['phone']) {
            $user->phone = $request['phone'];
            $message = 'Telefono actualizado con exito!';
        }

        if (strtolower($request['email']) !== strtolower($user->email) && $request['email']) {

            $user->email = strtolower($request['email']);
            $message = 'Correo actualizado con exito!';

        } else if(strtolower($request['email']) == strtolower($user->email) && $request['email']) {
            
            $message = 'El correo es el mismo';
        }

        $user->save();

        return response()->json([
            'message' => $message,
            "status" => true, 
            'user' => $user,
        ],200);

    }

    function updateProfilePhoto(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'photo' => ['mimes:jpg,jpeg,png', 'max:1024']
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        if (isset($request['photo'])) {

            $user->updateProfilePhoto($request['photo']);

            return response()->json([
                'message' => 'Foto actualizada con exito!',
                "status" => true, 
                'user' => $user,
            ],200);

        } else {
            return response()->json(['status' => false, 'errors' => "No se recibio la foto"],200);
        }

    }

    function updatePassword(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
            'newPassword' => [
                'required', 
                'string', 
                'min:8'
            ],
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'errors' => 'Su contraseña actual no coincide con la contraseña mandada.']);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        $message = "Contraseña actualizada";

        return response()->json([
            'message' => $message,
            "status" => true,
        ]);
        
    }

    public function restorePassword(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->where('status', 1)->first();

            if (!$user) {
                activity()
                
                ->causedBy($user)
                ->withProperties([
                    'request_data' => $request->all(),
                    'reason' => 'Correo no registrado'
                ])
                ->log('Correo de recuperación no enviado.');
                return response()->json(['message' => 'El correo no esta registrado'], 200);
            }

            activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'Correo' => $user->email,
                'Fecha' => now()
            ])
            ->log('Correo de recuperación enviado');

            Mail::to($request->email)->send(new RestorePassword($user));
            return response()->json(['message' => 'Enlace de restablecimiento de contraseña enviado con éxito'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteUser(Request $request) {
        // Obtener el usuario a eliminar usando el ID
        $user = User::findOrFail($request->user()->id);
        
        // Eliminar todos los tokens asociados al usuario
        $user->tokens()->delete();
        
        // Eliminar el usuario de la base de datos
        $user->delete();
        
        return response()->json(['status' => true, 'message' => 'Usuario eliminado'], 200);
    }

     public function getSessions(Request $request)
     {
         $user = $request->user();
         $sessions = $user->tokens->map(function ($token) {
             return [
                 'id' => $token->id,
                 'name' => $token->name,
                 'created_at' => $token->created_at,
                 'last_used_at' => $token->last_used_at,
             ];
         });
 
         return response()->json(['status' => true,'sessions' => $sessions], 200);
     }

     public function deleteSession(Request $request, $id)
    {
        $user = $request->user();
        $token = $user->tokens()->find($id);

        if (!$token) {
            return response()->json(['status' => false, 'message' => 'Sesión no encontrada'], 404);
        }

        $token->delete();
        return response()->json(['status' => true, 'message' => 'Sesión cerrada con éxito'], 200);
    }
}
