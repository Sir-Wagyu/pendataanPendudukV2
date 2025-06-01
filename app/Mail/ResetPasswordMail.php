<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.reset_password',
        );
    }

    public function build()
    {
        return $this->subject('Reset Password')
            ->view('emails.reset_password')
            ->with([
                'password' => $this->password,
            ]);
    }
}
