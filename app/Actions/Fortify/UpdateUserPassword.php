<?php

namespace App\Actions\Fortify;

use App\Mail\PasswordUpdatedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => [
                'required',
                'string',
                'min:8', // Mínimo 8 caracteres
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
                'regex:/[0-9]/', // Al menos un número
                function ($attribute, $value, $fail) use ($user) {
                    if (Hash::check($value, $user->password)) {
                        $fail(__('La nueva contraseña no puede ser igual a la contraseña anterior.'));
                    }
                },
            ],
        ], [
            'current_password.required' => __('El campo contraseña actual es obligatorio.'),
            'password.required' => __('El campo nueva contraseña es obligatorio.'),
            'current_password.current_password' => __('La contraseña proporcionada no coincide con su contraseña actual.'),
            'password.regex' => __('La contraseña debe contener al menos un carácter especial y un número.'),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();

        session()->flash('status', 'Tu contraseña ha sido actualizada exitosamente.');
        Mail::to($user->email)->send(new PasswordUpdatedNotification($user));
    }
}
