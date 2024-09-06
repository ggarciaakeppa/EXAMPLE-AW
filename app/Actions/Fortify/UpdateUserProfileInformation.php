<?php

namespace App\Actions\Fortify;

use App\Mail\UserDataUpdatedNotification;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // Validar los datos de entrada
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');
    
        // Actualizar la foto del perfil si se proporciona
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }
    
        // Actualizar el usuario con verificación de email
        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'phone' => $input['phone'],
                'email' => $input['email'],
            ])->save();
        }
    
        // Obtener los campos actualizados
        $updatedFields = $user->getChanges();
    
        // Enviar el correo de notificación solo si hay cambios
        if (!empty($updatedFields)) {
            Mail::to($user->email)->send(new UserDataUpdatedNotification($user));
        }
    }
    

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
