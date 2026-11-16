<?php

namespace App\Http\Controllers;

use App\Models\CachedTest;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Archives bulk tool runs (/tools/{slug}) so they can be reopened later from /test-archive.
 *
 * Tool runs are stored in the existing cached_tests table (no schema change):
 *  - test_key    "tool-<random>"  (analysis rows use numeric ref ids, so they never clash)
 *  - test_labels small JSON summary used by the archive list
 *  - result      everything bulk.js needs to rebuild the results table
 */
class ToolArchiveController extends Controller
{
    public const KEY_PREFIX = 'tool-';

    /** Largest payload we accept, in bytes. */
    protected const MAX_PAYLOAD = 20 * 1024 * 1024;

    public static function isToolKey(?string $key): bool
    {
        return is_string($key) && Str::startsWith($key, self::KEY_PREFIX);
    }

    /** All tools keyed by slug. */
    public static function toolsBySlug(): array
    {
        $tools = [];
        foreach ((new Helper())->getAllTests()['data'] as $tool) {
            $tools[$tool['slug']] = $tool;
        }

        return $tools;
    }

    public function store(Request $request)
    {
        $slug = (string) $request->input('slug');
        $raw = (string) $request->input('payload');

        $tools = self::toolsBySlug();
        if (! isset($tools[$slug])) {
            return response()->json(['success' => false, 'error' => 'Unknown tool'], 422);
        }
        if ($raw === '' || strlen($raw) > self::MAX_PAYLOAD) {
            return response()->json(['success' => false, 'error' => 'Invalid payload size'], 422);
        }

        $payload = json_decode($raw, true);
        if (! is_array($payload) || empty($payload['results']) || ! is_array($payload['results'])) {
            return response()->json(['success' => false, 'error' => 'Invalid payload'], 422);
        }

        $urls = array_values(array_filter(array_map('strval', (array) ($payload['urls'] ?? []))));
        $results = $payload['results'];
        $passed = count(array_filter($results, fn ($r) => ! empty($r['status'])));

        $summary = [
            'type' => 'tool',
            'slug' => $slug,
            'name' => $tools[$slug]['displayName'] ?? $tools[$slug]['main_heading'] ?? $slug,
            'url_count' => count($urls) ?: count($results),
            'passed' => $passed,
            'failed' => count($results) - $passed,
            'errors' => is_array($payload['resultsError'] ?? null) ? count($payload['resultsError']) : 0,
        ];

        $key = self::KEY_PREFIX . Str::lower(Str::random(20));

        CachedTest::create([
            'user_id' => Auth::id(),
            'test_key' => $key,
            'result' => [
                'type' => 'tool',
                'slug' => $slug,
                'urls' => $urls,
                'results' => $results,
                'resultsError' => is_array($payload['resultsError'] ?? null) ? $payload['resultsError'] : [],
                'settings' => $payload['settings'] ?? null,
            ],
            'test_labels' => json_encode($summary),
            'projectUrl' => Str::limit($urls[0] ?? '', 250, ''),
            'web_app' => 0,
        ]);

        return response()->json([
            'success' => true,
            'key' => $key,
            'url' => url('tools/' . $slug . '/archive/' . $key),
        ]);
    }

    public function show($slug, $key)
    {
        abort_unless(self::isToolKey($key), 404);

        $record = CachedTest::where('test_key', $key)->first();
        abort_unless($record && is_array($record->result), 404);

        $archive = $record->result;
        $tools = self::toolsBySlug();
        $savedSlug = $archive['slug'] ?? null;

        if (! $savedSlug || ! isset($tools[$savedSlug])) {
            abort(404);
        }
        // Keep links working if someone edits the slug part of the URL
        if ($savedSlug !== $slug) {
            return redirect()->route('tools.archive', ['slug' => $savedSlug, 'key' => $key]);
        }

        $d = $tools[$slug];
        $data = (new Helper())->getAllTests();

        $archive['createdAt'] = optional($record->created_at)->format('j M Y, h:i A');

        return view('bulk-tools.show', [
            'data' => $data,
            'd' => $d,
            'slug' => $slug,
            'toolArchive' => $archive,
            'headerPadding' => 'tool_pages',
        ]);
    }
}
