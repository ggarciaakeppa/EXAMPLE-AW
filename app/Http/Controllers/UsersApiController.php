<?php

namespace App\Http\Controllers;

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
/* use Illuminate\Validation\Rules\Password; */

class UsersApiController extends Controller
{
    /* public function passwordRules()
    {
        return [
            'password' => [
                'required',
                Password::min(8)
            ],
            'password_confirmation' => 'required|same:password'
        ];
    } */

    /* protected $messages = [
        'name.required' => 'El nombre no puede ir vacio.',
        'last_name.required' => 'Los apellidos no pueden ir vacios.',
        'phone.required' => 'Deberia haber un medio de contacto',
        'email.required' => 'El correo no puede ir vacio.',
        'email.email' => 'El formato de correo no es valido',
        'email.unique' => 'El correo ya esta en uso',
    ]; */

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

        /* return $user->createToken($request->device_name)->plainTextToken; */
        /* return $user->createToken("Movil")->plainTextToken; */
    
        /* return response()->json(['status' => true, 'user' => $user]); */
        /* return $request->user(); */
        $token =  $user->createToken('api')->plainTextToken;

        return response()->json(['status' => true, 'token' => $token]);
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
            /* throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]); */
            return response()->json(['status' => false, 'errors' => 'Las credenciales son incorrectas.']);
        }
     
        //return $user->createToken("TramitApp")->plainTextToken;
        //return response()->json(['status' => true, 'user' => auth()->user()]);

        /* $token =  $request->user()->createToken('api');

        return response()->json(['status' => true, 'token' => $token->plainTextToken]); */

        $token =  $user->createToken('api')->plainTextToken;

        return response()->json(['status' => true, 'token' => $token]);
    }

    public function loginPrev(Request $request)
    {
        $this->validateLogin($request);
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        }
        return response()->json([
        'token' => $request->user()->createToken($request->device)->plainTextToken,
        'message' => 'Success'
        ]);
    }
    public function validateLogin(Request $request)
    {
        return $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device' => 'required'
        ]);
    }

    function logout(Request $request) {
        $user = $request->user();

        //return $user;

        $user->tokens()->delete();
    
        return http_response_code(201);
    }

    function user(Request $request) {
        $user = $request->user();
        return $user;
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
            ]);

        } else {
            return response()->json(['status' => false, 'errors' => "No se recibio la foto"]);
        }

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
            $message = 'Celular actualizado con exito!';
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
        ]);

    }

    function updatePassword(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
            'newPassword' => ['required', 'string', 'min:6'],
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

    function addExpediente(Request $request) {
        $user = $request->user();

        $expediente = new Expediente();
        $expediente->image = $request->images;
        $expediente->tipo = $request->doc;
        $expediente->user_id = $user->id;
        $expediente->save();

        return response()->json([
            'message' => 'Expediente agregado con exito!',
            "status" => true, 
        ]);
    }

    function deleteExpediente(Request $request) {
        $user = $request->user();
        $expediente = Expediente::find($request->id);
        
        foreach($expediente->image as $image) {
            Storage::disk('private')->delete("/expediente/photo/".$user->id.'/'.$image);
        }

        $expediente->delete();

        return response()->json([
            'message' => 'Documentos eliminados con exito!',
            "status" => true, 
        ]);
    }

    function getExpedienteTipo(Request $request) {
        $user = $request->user();

        $expediente_tipo = DB::table('expediente_tipo')
        ->whereRaw('NOT EXISTS (SELECT NULL
        FROM expediente t2
        WHERE t2.tipo = expediente_tipo.id AND t2.user_id = '.$user->id.')')
        ->get();

        return response()->json([
            'expediente_tipo' => $expediente_tipo,
            "status" => true,
        ]);
        
    }

    function getExpediente(Request $request) {
        $user = $request->user();

        $expedientes = Expediente::select('expediente.id','expediente_tipo.nombre','expediente.image','expediente.created_at','expediente.updated_at')
        ->join('expediente_tipo', 'expediente_tipo.id', '=', 'expediente.tipo')
        ->where('user_id', $user->id)
        ->get();

        $expediente_tipo = DB::table('expediente_tipo')
        ->whereRaw('NOT EXISTS (SELECT NULL
        FROM expediente t2
        WHERE t2.tipo = expediente_tipo.id AND t2.user_id = '.$user->id.')')
        ->get();

        /* foreach($expedientes as $expediente) {
            $expediente->created_at = $expediente->created_at->format("d-m-Y");
            $expediente->updated_at = $expediente->updated_at->format("d-m-Y");
        } */

        return response()->json([
            'expediente_tipo' => $expediente_tipo,
            'expedientes' => $expedientes,
            "status" => true,
        ]);
        
    }

    public function getExpedienteImage(Request $request, $uri)
    {
        /* $token = PersonalAccessToken::where('token', $request->hashedToken)->first(); */
        $token = PersonalAccessToken::findToken($request->hashedToken);

        $user = $token->tokenable;

        abort_if(
        ! Storage::disk('private')->exists("/expediente/photo/".$user->id."/".$uri),
        404,
        "No se encuentra el archivo."
        );


        return Storage::disk('private')->response("/expediente/photo/".$user->id."/".$uri);
    }

    function uploadExpedientePhoto(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'photo' => ['mimes:jpg,jpeg,png', 'max:8192']
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        if (isset($request['photo'])) {

            $fileName = uniqid().'.'.$request['photo']->getClientOriginalExtension();
            $path = "expediente/photo/".$user->id.'/';

            $file = \Request::file('photo');
            \Storage::disk('private')->put($path.$fileName,  \File::get($file));

            return response()->json([
                'message' => 'Foto subida con exito!',
                "status" => true, 
                'uri' => $fileName,
            ]);

        } else {
            return response()->json(['status' => false, 'errors' => "No se recibio la foto"]);
        }

    }

    function deleteExpedientePhoto(Request $request) {
        $user = $request->user();

        Storage::disk('private')->delete("/expediente/photo/".$user->id.'/'.$request->uri);

        return response()->json([
            'message' => 'Foto eliminada con exito!',
            "status" => true, 
        ]);
    }

    function uploadFileSolicitud(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'archivo' => ['mimes:jpg,jpeg,png', 'max:8192'],
            /* 'factura' => ['mimes:jpg,jpeg,png', 'max:8192'] */
        ], $this->messages());

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        if (isset($request['archivo'])) {

            $fileName = uniqid().'.'.$request['archivo']->getClientOriginalExtension();
            $path = "solicitud/files/".$user->id.'/';

            $file = \Request::file('archivo');
            \Storage::disk('private')->put($path.$fileName,  \File::get($file));

            return response()->json([
                'message' => 'Imagen subida con exito!',
                "status" => true, 
                'uri' => $fileName,
            ]);

        } /* else if (isset($request['factura'])) {

            $fileName = uniqid().'.'.$request['factura']->getClientOriginalExtension();
            $path = "solicitud/files/".$user->id.'/';

            $file = \Request::file('factura');
            \Storage::disk('private')->put($path.$fileName,  \File::get($file));

            return response()->json([
                'message' => 'Imagen subida con exito!',
                "status" => true, 
                'uri' => $fileName,
            ]);

        }  */else {
            return response()->json(['status' => false, 'errors' => "No se recibio la foto"]);
        }

    }

    function deleteFileSolicitud(Request $request) {
        $user = $request->user();

        Storage::disk('private')->delete("/solicitud/files/".$user->id.'/'.$request->uri);

        return response()->json([
            'message' => 'Foto eliminada con exito!',
            "status" => true, 
        ]);
    }

    public function getSolicitudImage(Request $request, $uri)
    {
        $token = PersonalAccessToken::findToken($request->hashedToken);

        $user = $token->tokenable;

        abort_if(
        ! Storage::disk('private')->exists("/solicitud/files/".$user->id."/".$uri),
        404,
        "No se encuentra el archivo."
        );


        return Storage::disk('private')->response("/solicitud/files/".$user->id."/".$uri);
    }

    function getNoticias(Request $request) {
        $noticias = Noticias::where('status','Publicada')->orderBy('created_at','DESC')->paginate(5);

        return $noticias;
    }

    function addSolicitud(Request $request) {
        $user = $request->user();

        $viewIfSolicitud = Solicitud::leftJoin('solicitud_status', function($query) {
            $query->on('solicitud_status.solicitud','=','solicitud.id')
                ->whereRaw('solicitud_status.id IN (select MAX(a2.id) from solicitud_status as a2 join solicitud as u2 on u2.id = a2.solicitud group by u2.id)');
        })
        ->where('solicitud.tipo', $request->tipo)
        ->where('solicitud.solicitud', $request->solicitud)
        ->where('solicitud.user_id', $user->id)
        ->where('solicitud_status.status', '<>', 'RECHAZADA')
        ->first();

        if($viewIfSolicitud) {
            return response()->json([
                'message' => 'Ya tienes esta solicitud!',
                "status" => false, 
            ]);
        }

        $solicitud = new Solicitud();
        $solicitud->tipo = $request->tipo;
        $solicitud->solicitud = $request->solicitud;
        $solicitud->archivos = $request->archivos;
        /* $expediente->status = "EN REVISIÓN"; */
        $solicitud->user_id = $user->id;
        $solicitud->save();

        $status = new Solicitud_status();
        $status->status = "EN REVISIÓN";
        $status->solicitud = $solicitud->id;
        $status->save();

        return response()->json([
            'message' => 'Solicitud agregado con exito!',
            "status" => true, 
        ]);
    }

    function updateSolicitud(Request $request, $id) {
        $user = $request->user();

        $solicitud = Solicitud::find($id);
        $archivo[$request->index] = $request->archivo;
        $solicitud->archivos = array_replace($solicitud->archivos, $archivo);
        $solicitud->save();

        $status = new Solicitud_status();
        $status->status = "MODIFICADO PARA REVISIÓN";
        $status->solicitud = $solicitud->id;
        $status->save();

        return response()->json([
            'message' => 'Solicitud modificada con exito!',
            "status" => true, 
        ]);
    }

    function addComentario(Request $request) {
        $user = $request->user();

        $comentario = new Solicitud_comentarios();
        $comentario->comentario = $request->comentario;
        $comentario->solicitud = $request->solicitud;
        $comentario->user_id = $user->id;
        $comentario->save();

        return response()->json([
            'message' => 'Comentario agregado con exito!',
            "status" => true, 
        ]);
    }

    function getSolicitudes(Request $request) {
        $user = $request->user();

        $solicitudes = Solicitud::select('solicitud.id','solicitud.solicitud','solicitud.tipo','solicitud_status.status','solicitud.tipo','solicitud.updated_at')
        ->leftJoin('solicitud_status', function($query) {
            $query->on('solicitud_status.solicitud','=','solicitud.id')
                ->whereRaw('solicitud_status.id IN (select MAX(a2.id) from solicitud_status as a2 join solicitud as u2 on u2.id = a2.solicitud group by u2.id)');
        })
        ->where('user_id', $user->id)
        ->get();

        return $solicitudes;
    }

    function getDataSolicitud(Request $request, $id) {
        $user = $request->user();

        $solicitud = Solicitud::select('solicitud.*','solicitud_status.status')
        ->leftJoin('solicitud_status', function($query) {
            $query->on('solicitud_status.solicitud','=','solicitud.id')
                ->whereRaw('solicitud_status.id IN (select MAX(a2.id) from solicitud_status as a2 join solicitud as u2 on u2.id = a2.solicitud group by u2.id)');
        })
        ->where('user_id', $user->id)
        ->where('solicitud.id', $id)
        ->first();

        $status = Solicitud_status::select('solicitud_status.*')
        ->where('solicitud_status.solicitud', $solicitud->id)
        ->get();

        $comentarios = Solicitud_comentarios::select('solicitud_comentarios.*')
        ->where('solicitud_comentarios.solicitud', $solicitud->id)
        ->get();

        foreach($comentarios as $comentario) {
            if($comentario->user_id == $user->id) {
                $comentario->user = "Yo";
            } else {
                $comentario->user = "Revisor";
            }
        }

        return response()->json([
            'solicitud' => $solicitud,
            'solicitud_status' => $status,
            'comentarios' => $comentarios,
            "status" => true, 
        ]);
    }

}
