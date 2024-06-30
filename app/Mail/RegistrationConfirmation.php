<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user_purpose)
    {
        $this->token = $token;
        $this->user_purpose = $user_purpose;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->user_purpose == "Professional Network"){
            return $this->subject('Registration Confirmation')
                    ->view('emails.registration_confirmation_professional_network')
                    ->with(['token' => $this->token]);
        }
        else{
            return $this->subject('Registration Confirmation')
            ->view('emails.registration_confirmation')
            ->with(['token' => $this->token]);
        }
        
    }
}
