<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array{name?: string, email: string, firstName: string} */
    public $data;

    public string $firstName;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->firstName = $data['firstName'] ?? 'there';
    }

    public function build()
    {
        $subject = "Welcome to WebQA - Let’s find and fix issues on your website";

        return $this
            ->subject($subject)
            ->view('emails.welcome', [
                'firstName' => $this->firstName,
            ]);
    }
}
