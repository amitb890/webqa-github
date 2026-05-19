<?php

namespace App\Services;

use App\Models\projectSettings;
use App\Models\TestLabel;

class DashboardLabelsService
{
    /**
     * Active labels grouped by category (same shape as GET /get-all-labels/{id}).
     *
     * @return array{all_labels: array, seo_labels: array, performance_labels: array, cbp_labels: array, security_labels: array}
     */
    public static function groupedLabelsForProject(int $projectId): array
    {
        $activeSettingsLabels = [];
        $activeSettingsSeoLabels = [];
        $activeSettingsPerformanceLabels = [];
        $activeSettingsCbpLabels = [];
        $activeSettingsSecurityLabels = [];

        $allLabels = TestLabel::where('project_id', $projectId)->get();
        $seoLabels = TestLabel::where('project_id', $projectId)->where('parent', 'seo')->get();
        $performanceLabels = TestLabel::where('project_id', $projectId)->where('parent', 'performance')->get();
        $cbpLabels = TestLabel::where('project_id', $projectId)->where('parent', 'bestPractices')->get();
        $securityLabels = TestLabel::where('project_id', $projectId)->where('parent', 'security')->get();

        $settingsLabels = projectSettings::where('projects_id', $projectId)->first();

        if (!$settingsLabels) {
            return [
                'all_labels' => [],
                'seo_labels' => [],
                'performance_labels' => [],
                'cbp_labels' => [],
                'security_labels' => [],
            ];
        }

        $settingsArray = $settingsLabels->toArray();

        foreach ($settingsArray as $key => $value) {
            foreach ($allLabels as $label) {
                if ($label->db_name === $key && (int) $value === 1) {
                    $activeSettingsLabels[] = $label;
                }
            }
        }

        foreach ($settingsArray as $key => $value) {
            foreach ($seoLabels as $label) {
                if ($label->db_name === $key && (int) $value === 1) {
                    $activeSettingsSeoLabels[] = $label;
                }
            }
        }

        foreach ($settingsArray as $key => $value) {
            foreach ($performanceLabels as $label) {
                if ($label->db_name === $key && (int) $value === 1) {
                    $activeSettingsPerformanceLabels[] = $label;
                }
            }
        }

        foreach ($settingsArray as $key => $value) {
            foreach ($cbpLabels as $label) {
                if ($label->db_name === $key && (int) $value === 1) {
                    $activeSettingsCbpLabels[] = $label;
                }
            }
        }

        foreach ($settingsArray as $key => $value) {
            foreach ($securityLabels as $label) {
                if ($label->db_name === $key && (int) $value === 1) {
                    $activeSettingsSecurityLabels[] = $label;
                }
            }
        }

        return [
            'all_labels' => $activeSettingsLabels,
            'seo_labels' => $activeSettingsSeoLabels,
            'performance_labels' => $activeSettingsPerformanceLabels,
            'cbp_labels' => $activeSettingsCbpLabels,
            'security_labels' => $activeSettingsSecurityLabels,
        ];
    }
}
