<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Support\UserDisplayName;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public function handle(Registered $event): void
    {
        $user = $event->user;

        try {
            Mail::to($user->email)->queue(new WelcomeMail([
                'name' => $user->name,
                'email' => $user->email,
                'firstName' => UserDisplayName::firstName($user->name),
            ]));
        } catch (\Throwable $e) {
            Log::error('Welcome email failed to queue', [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
