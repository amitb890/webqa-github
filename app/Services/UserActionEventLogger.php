<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserActionEventLogger
{
    public static function success(string $action, ?string $message = null, array $context = [], ?Request $request = null, ?User $user = null): void
    {
        self::record($action, 'success', $message, $context, $request, $user);
    }

    public static function failed(string $action, ?string $message = null, array $context = [], ?Request $request = null, ?User $user = null): void
    {
        self::record($action, 'failed', $message, $context, $request, $user);
    }

    public static function info(string $action, ?string $message = null, array $context = [], ?Request $request = null, ?User $user = null): void
    {
        self::record($action, 'info', $message, $context, $request, $user);
    }

    public static function record(string $action, string $status, ?string $message = null, array $context = [], ?Request $request = null, ?User $user = null): void
    {
        try {
            $request = $request ?: request();
            $user = $user ?: auth()->user();

            UserActionEvent::create([
                'user_id' => $user ? $user->id : null,
                'email' => $context['email'] ?? ($user ? $user->email : null),
                'action' => $action,
                'source' => $context['source'] ?? null,
                'status' => $status,
                'subject_type' => $context['subject_type'] ?? null,
                'subject_id' => $context['subject_id'] ?? null,
                'url' => $context['url'] ?? $request->fullUrl(),
                'message' => $message,
                'context' => $context,
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Unable to record user action event: ' . $e->getMessage(), [
                'action' => $action,
                'status' => $status,
            ]);
        }
    }
}
