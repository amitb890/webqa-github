<?php

namespace App\Support;

class UserDisplayName
{
    public static function firstName(?string $full): string
    {
        $full = trim((string) $full);
        if ($full === '') {
            return 'there';
        }

        $parts = preg_split('/\s+/u', $full);

        return ($parts[0] ?? '') !== '' ? $parts[0] : 'there';
    }
}
