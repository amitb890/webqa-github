<?php

namespace App\Support;

final class LighthouseUrlParser
{
    /**
     * @return list<string>
     */
    public static function fromRequestList(mixed $urls): array
    {
        if (! is_array($urls)) {
            return [];
        }

        $normalized = [];
        foreach ($urls as $url) {
            $urlString = self::resolveEntry($url);
            if ($urlString !== '') {
                $normalized[] = $urlString;
            }
        }

        return $normalized;
    }

    /**
     * @return list<string>
     */
    public static function fromStoredJson(?string $json): array
    {
        if ($json === null || $json === '') {
            return [];
        }

        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $trimmed = trim($json);

            return $trimmed !== '' ? [$trimmed] : [];
        }

        return self::fromDecoded($decoded);
    }

    /**
     * @return list<string>
     */
    public static function fromDecoded(mixed $decoded): array
    {
        if (is_string($decoded)) {
            $trimmed = trim($decoded);

            return $trimmed !== '' ? [$trimmed] : [];
        }

        if (! is_array($decoded)) {
            return [];
        }

        // Single {"url":"..."} object stored instead of a list.
        if (isset($decoded['url']) && self::isList($decoded) === false) {
            $single = self::resolveEntry($decoded);

            return $single !== '' ? [$single] : [];
        }

        $normalized = [];
        foreach ($decoded as $entry) {
            $urlString = self::resolveEntry($entry);
            if ($urlString !== '') {
                $normalized[] = $urlString;
            }
        }

        return $normalized;
    }

    public static function resolveEntry(mixed $entry): string
    {
        if (is_string($entry)) {
            return trim($entry);
        }

        if (is_array($entry)) {
            if (! array_key_exists('url', $entry)) {
                return '';
            }

            $value = $entry['url'];

            return is_string($value) ? trim($value) : (is_scalar($value) ? trim((string) $value) : '');
        }

        if (is_object($entry) && isset($entry->url)) {
            return trim((string) $entry->url);
        }

        return '';
    }

    /**
     * @param  array<mixed>  $array
     */
    private static function isList(array $array): bool
    {
        if (function_exists('array_is_list')) {
            return array_is_list($array);
        }

        $expected = 0;
        foreach ($array as $key => $_) {
            if ($key !== $expected) {
                return false;
            }
            $expected++;
        }

        return true;
    }
}
