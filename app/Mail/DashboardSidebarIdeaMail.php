<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DashboardSidebarIdeaMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    public $leadName;

    /** @var string */
    public $leadEmail;

    /** @var string */
    public $leadUrl;

    /** @var string */
    public $issue;

    /** @var string */
    public $severity;

    /** @var string|null */
    protected $attachmentAbsolutePath;

    /** @var string|null */
    protected $attachmentDisplayName;

    public function __construct(
        string $leadName,
        string $leadEmail,
        string $leadUrl,
        string $issue,
        string $severity,
        ?string $attachmentAbsolutePath = null,
        ?string $attachmentDisplayName = null
    ) {
        $this->leadName = $leadName;
        $this->leadEmail = $leadEmail;
        $this->leadUrl = $leadUrl;
        $this->issue = $issue;
        $this->severity = $severity;
        $this->attachmentAbsolutePath = $attachmentAbsolutePath;
        $this->attachmentDisplayName = $attachmentDisplayName;
    }

    public function build()
    {
        $mail = $this
            ->subject('WebQA dashboard — Submit your idea')
            ->view('emails.dashboard-sidebar-idea');

        if ($this->attachmentAbsolutePath && is_readable($this->attachmentAbsolutePath)) {
            $mail->attach($this->attachmentAbsolutePath, [
                'as' => $this->attachmentDisplayName ?: basename($this->attachmentAbsolutePath),
            ]);
        }

        return $mail;
    }
}
