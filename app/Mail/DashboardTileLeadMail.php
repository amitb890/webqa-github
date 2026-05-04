<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DashboardTileLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    public $leadEmail;

    /** @var string */
    public $leadMessage;

    public function __construct(string $leadEmail, string $leadMessage)
    {
        $this->leadEmail = $leadEmail;
        $this->leadMessage = $leadMessage;
    }

    public function build()
    {
        return $this
            ->subject('WebQA dashboard — new lead')
            ->view('emails.dashboard-tile-lead');
    }
}
