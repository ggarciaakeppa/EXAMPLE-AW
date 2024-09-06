<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserDataUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $updatedFields;
   
     /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
       
    }

  /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tus datos han sido actualizados')
                    ->view('emails.user_data_updated');
    }
}
