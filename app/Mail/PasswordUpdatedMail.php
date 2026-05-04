<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $firstName;

    public function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function build()
    {
        return $this
            ->subject('Your WebQA password has been updated')
            ->view('emails.password-updated');
    }
}
