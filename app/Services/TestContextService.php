<?php

namespace App\Services;

use App\Models\projectSettings;
use App\Models\SettingsSub;
use App\Models\TestResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TestContextService
{
    public const MODE_PROJECT = 'project';

    public const MODE_DEFAULT = 'default';

    public const MODE_SNAPSHOT = 'snapshot';

    /** Frontend / settings-page keys mapped to DB column names. */
    private const KEY_ALIASES = [
        'casingCamel' => 'title_casing_camel',
        'casingBoth' => 'title_casing_both',
        'casingSentence' => 'title_casing_sentence',
        'isMetaTitle' => 'meta_title',
        'ogTitleCasingCamel' => 'og_title_casing_camel',
        'ogTitleCasingBoth' => 'og_title_casing_both',
        'ogTitleCasingSentence' => 'og_title_casing_sentence',
        'twitterTitleCasingCamel' => 'twitter_title_casing_camel',
        'twitterTitleCasingBoth' => 'twitter_title_casing_both',
        'twitterTitleCasingSentence' => 'twitter_title_casing_sentence',
    ];

    /**
     * @param  array<string, mixed>  $collectData
     * @return array{mode: string, project_id: ?int, snapshot: ?array<string, mixed>}
     */
    public function resolveCollectContext(array $collectData, ?projectSettings $defaultSettings = null): array
    {
        $project = $collectData['project'] ?? null;

        if ($project === 'default') {
            if (! $defaultSettings) {
                return ['mode' => self::MODE_DEFAULT, 'project_id' => null, 'snapshot' => null];
            }

            return [
                'mode' => self::MODE_DEFAULT,
                'project_id' => $defaultSettings->projects_id ? (int) $defaultSettings->projects_id : null,
                'snapshot' => null,
            ];
        }

        if ($project === 'bulk' || $project === 'analysis') {
            $rawSub = $collectData['settingsVal']['settings_sub'] ?? [];

            return [
                'mode' => self::MODE_SNAPSHOT,
                'project_id' => null,
                'snapshot' => $this->normalizeSnapshot(is_array($rawSub) ? $rawSub : []),
            ];
        }

        return [
            'mode' => self::MODE_PROJECT,
            'project_id' => is_numeric($project) ? (int) $project : null,
            'snapshot' => null,
        ];
    }

    /**
     * @param  array<string, mixed>  $snapshot
     * @return array<string, mixed>
     */
    public function normalizeSnapshot(array $snapshot): array
    {
        $normalized = [];

        foreach ($snapshot as $key => $value) {
            $dbKey = self::KEY_ALIASES[$key] ?? $key;
            $normalized[$dbKey] = $value;
        }

        return array_merge($this->columnDefaults(), $normalized);
    }

    /**
     * @return array<string, mixed>
     */
    public function columnDefaults(): array
    {
        static $defaults = null;

        if ($defaults !== null) {
            return $defaults;
        }

        $defaults = [];

        try {
            $columns = DB::select('SHOW COLUMNS FROM project_settings_sub');
            foreach ($columns as $column) {
                if (in_array($column->Field, ['id', 'project_settings_id'], true)) {
                    continue;
                }
                $defaults[$column->Field] = $this->castColumnDefault($column->Default);
            }
        } catch (\Throwable $e) {
            $defaults = $this->fallbackColumnDefaults();
        }

        return $defaults;
    }

    /**
     * @return object{settings_sub: object}
     */
    public function resolveSettingsWrapper(?Request $request = null): object
    {
        $request = $request ?? request();
        $refId = $this->extractRefId($request);

        if ($refId) {
            $fromContext = $this->settingsFromRefId($refId);
            if ($fromContext !== null) {
                return $fromContext;
            }
        }

        return $this->settingsFromSession();
    }

    public function extractRefId(?Request $request): ?string
    {
        if (! $request) {
            return null;
        }

        $refId = $request->input('ref_id');
        if ($refId) {
            return (string) $refId;
        }

        $data = $request->input('data');
        if (is_array($data) && ! empty($data['ref_id'])) {
            return (string) $data['ref_id'];
        }

        return null;
    }

    /**
     * @return object{settings_sub: object}|null
     */
    public function settingsFromRefId(string $refId): ?object
    {
        $test = TestResults::where('ref_id', $refId)->first();
        if (! $test || ! $test->settings_mode) {
            return null;
        }

        if ($test->settings_mode === self::MODE_SNAPSHOT) {
            $snapshot = json_decode($test->settings_snapshot ?? '', true);
            if (! is_array($snapshot)) {
                $snapshot = [];
            }

            return (object) [
                'settings_sub' => (object) $this->normalizeSnapshot($snapshot),
            ];
        }

        if ($test->settings_mode === self::MODE_DEFAULT) {
            if ($test->project_id) {
                $settings = projectSettings::where('projects_id', $test->project_id)
                    ->with('settingsSub')
                    ->first();

                if ($settings && $settings->settingsSub) {
                    return $this->wrapSettingsSub($settings->settingsSub);
                }
            }

            $settings = $this->resolveDefaultProjectSettings();
            if ($settings && $settings->settingsSub) {
                return $this->wrapSettingsSub($settings->settingsSub);
            }
        }

        if ($test->settings_mode === self::MODE_PROJECT && $test->project_id) {
            $settings = projectSettings::where('projects_id', $test->project_id)
                ->with('settingsSub')
                ->first();

            if ($settings && $settings->settingsSub) {
                return $this->wrapSettingsSub($settings->settingsSub);
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    public function mergeSettingsSub(array $overrides = []): object
    {
        return (object) array_merge($this->columnDefaults(), $overrides);
    }

    /**
     * @return object{settings_sub: object}
     */
    protected function settingsFromSession(): object
    {
        $raw = Session::get('settings');
        if ($raw === null || $raw === '') {
            return (object) [
                'settings_sub' => (object) $this->columnDefaults(),
            ];
        }

        $settings = is_string($raw) ? json_decode($raw) : $raw;
        if (! is_object($settings)) {
            return (object) [
                'settings_sub' => (object) $this->columnDefaults(),
            ];
        }

        $sub = $settings->settings_sub ?? null;
        if (is_array($sub)) {
            $sub = (object) $this->normalizeSnapshot($sub);
        } elseif (is_object($sub)) {
            $sub = (object) $this->normalizeSnapshot((array) $sub);
        } else {
            $sub = (object) $this->columnDefaults();
        }

        $settings->settings_sub = $sub;

        return $settings;
    }

    protected function wrapSettingsSub(SettingsSub $settingsSub): object
    {
        $attributes = $settingsSub->getAttributes();
        unset($attributes['id'], $attributes['project_settings_id']);

        return (object) [
            'settings_sub' => (object) array_merge($this->columnDefaults(), $attributes),
        ];
    }

    protected function resolveDefaultProjectSettings(): ?projectSettings
    {
        $settings = projectSettings::where('type', 'default')
            ->with('settingsSub')
            ->first();

        if ($settings && $settings->settingsSub) {
            return $settings;
        }

        return projectSettings::with('settingsSub')
            ->whereHas('settingsSub')
            ->orderBy('id')
            ->first();
    }

    /**
     * @param  mixed  $default
     * @return mixed
     */
    protected function castColumnDefault($default)
    {
        if ($default === null) {
            return null;
        }

        if ($default === 'NULL') {
            return null;
        }

        if (is_numeric($default)) {
            return str_contains((string) $default, '.') ? (float) $default : (int) $default;
        }

        return $default;
    }

    /**
     * @return array<string, mixed>
     */
    protected function fallbackColumnDefaults(): array
    {
        return [
            'meta_title' => 1,
            'max_title_length' => 1,
            'max_title_length_val' => 65,
            'min_title_length' => 0,
            'min_title_length_val' => 0,
            'title_casing_both' => 1,
            'title_casing_camel' => 0,
            'title_casing_sentence' => 0,
            'is_excluded_words' => 0,
            'excluded_words' => '',
            'meta_desc' => 1,
            'max_desc_length' => 1,
            'max_desc_length_val' => 160,
            'min_desc_length' => 0,
            'min_desc_length_val' => 0,
            'og_title_casing_camel' => 1,
            'og_title_casing_both' => 0,
            'og_title_casing_sentence' => 0,
            'twitter_title_casing_camel' => 1,
            'twitter_title_casing_both' => 0,
            'twitter_title_casing_sentence' => 0,
        ];
    }
}
