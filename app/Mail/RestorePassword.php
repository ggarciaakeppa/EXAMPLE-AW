<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

// Implementacion de colas implements ShouldQueue, solo ya en ambiente de prod
class RestorePassword extends Mailable 
{
    use Queueable, SerializesModels;


    public $user;
    public $resetPasswordUrl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;

        // Generar el token de restablecimiento de contraseña
        $token = Password::createToken($this->user);

        // Crear la URL de restablecimiento de contraseña
        $this->resetPasswordUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $this->user->email,
        ], false));
    }

        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Restablecer tu contraseña')
        ->view('emails.restore_password')
        ->with([
            'resetPasswordUrl' => $this->resetPasswordUrl,
        ]);
    }
 
}
