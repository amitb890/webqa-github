<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PageSpeedCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $firstName;

    public string $projectName;

    public int $urlCount;

    public string $reportUrl;

    public function __construct(string $firstName, string $projectName, int $urlCount, string $reportUrl)
    {
        $this->firstName = $firstName;
        $this->projectName = $projectName;
        $this->urlCount = $urlCount;
        $this->reportUrl = $reportUrl;
    }

    public function build()
    {
        return $this
            ->subject('Your Page Speed scores are ready for '.$this->projectName)
            ->view('emails.page-speed-completed');
    }
}
