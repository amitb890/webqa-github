<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AboutLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $leadName;

    public string $leadEmail;

    public string $leadSubject;

    public string $leadMessage;

    public function __construct(string $leadName, string $leadEmail, string $leadSubject, string $leadMessage)
    {
        $this->leadName = $leadName;
        $this->leadEmail = $leadEmail;
        $this->leadSubject = $leadSubject;
        $this->leadMessage = $leadMessage;
    }

    public function build()
    {
        $subject = $this->leadSubject !== ''
            ? 'About us contact: '.$this->leadSubject
            : 'New lead from About us page';

        $mail = $this
            ->subject($subject)
            ->replyTo($this->leadEmail, $this->leadName !== '' ? $this->leadName : null)
            ->view('emails.about-lead');

        return $mail;
    }
}
