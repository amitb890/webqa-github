<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsSub;
use App\Models\projectSettings;
use Illuminate\Support\Facades\Validator;

class BrokenLinksController extends Controller
{
    /**
     * Ignore a single broken link URL
     */
    public function ignoreUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer|exists:projects,id',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // First get the project settings record
            $projectSettings = projectSettings::where('projects_id', $request->project_id)->first();
            
            if (!$projectSettings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project settings not found'
                ], 404);
            }

            // Then get the settings sub record
            $settingsSub = SettingsSub::where('project_settings_id', $projectSettings->id)->first();
            
            if (!$settingsSub) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project settings sub not found'
                ], 404);
            }

            // Get current excluded URLs
            $excludedUrls = $settingsSub->broken_links_excluded_urls ? 
                array_map('trim', explode("\n", $settingsSub->broken_links_excluded_urls)) : [];

            // Add new URL if not already in the list
            if (!in_array($request->url, $excludedUrls)) {
                $excludedUrls[] = $request->url;
                $settingsSub->broken_links_excluded_urls = implode("\n", $excludedUrls);
                $settingsSub->broken_links_exclude_urls = true;
                $settingsSub->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'URL added to ignore list successfully',
                'url' => $request->url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request'
            ], 500);
        }
    }

    /**
     * Ignore all broken links URLs
     */
    public function ignoreAllUrls(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer|exists:projects,id',
            'urls' => 'required|array',
            'urls.*' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // First get the project settings record
            $projectSettings = projectSettings::where('projects_id', $request->project_id)->first();
            
            if (!$projectSettings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project settings not found'
                ], 404);
            }

            // Then get the settings sub record
            $settingsSub = SettingsSub::where('project_settings_id', $projectSettings->id)->first();
            
            if (!$settingsSub) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project settings sub not found'
                ], 404);
            }

            // Get current excluded URLs
            $excludedUrls = $settingsSub->broken_links_excluded_urls ? 
                array_map('trim', explode("\n", $settingsSub->broken_links_excluded_urls)) : [];

            // Add new URLs if not already in the list
            $addedUrls = [];
            foreach ($request->urls as $url) {
                if (!in_array($url, $excludedUrls)) {
                    $excludedUrls[] = $url;
                    $addedUrls[] = $url;
                }
            }

            if (!empty($addedUrls)) {
                $settingsSub->broken_links_excluded_urls = implode("\n", $excludedUrls);
                $settingsSub->broken_links_exclude_urls = true;
                $settingsSub->save();
            }

            return response()->json([
                'success' => true,
                'message' => count($addedUrls) . ' URL(s) added to ignore list successfully',
                'added_urls' => $addedUrls,
                'total_added' => count($addedUrls)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request'
            ], 500);
        }
    }
}
