<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $firstName;

    public string $resetUrl;

    public function __construct(string $firstName, string $resetUrl)
    {
        $this->firstName = $firstName;
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this
            ->subject('Reset your password - WebQA')
            ->view('emails.forgot-password');
    }
}
