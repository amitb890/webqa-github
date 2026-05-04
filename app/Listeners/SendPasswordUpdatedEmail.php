<?php

namespace App\Listeners;

use App\Mail\PasswordUpdatedMail;
use App\Support\UserDisplayName;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPasswordUpdatedEmail
{
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        try {
            Mail::to($user->email)->send(new PasswordUpdatedMail(
                UserDisplayName::firstName($user->name)
            ));
        } catch (\Throwable $e) {
            Log::warning('Password updated email failed: '.$e->getMessage(), [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }
    }
}
