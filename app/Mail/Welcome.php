<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $generatedPassword;

    public $user;

    public function __construct($generatedPassword,$user)
    {
        $this->generatedPassword = $generatedPassword;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Correo de bienvenida',
        );
    }


    public function build()
    {
        return $this->view('emails.welcome_email')
                    ->with([
                        'generatedPassword' => $this->generatedPassword,
                        'user' => $this->user
                    ]);
    }

}
