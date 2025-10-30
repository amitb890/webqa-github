<?php

namespace App\Http\Controllers;

use App\Jobs\RunLighthouseTest;
use App\Models\LighthouseTest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ProjectsController;

use Illuminate\Support\Facades\Auth;

class LighthouseController extends Controller
{
    public function startTests(Request $request)
    {
        $projectsController = new ProjectsController();
        $urls = $request->input('urls');
        $project_id = $request->input('project_id');

        if (empty($urls) || !is_array($urls)) {
            return response()->json(['error' => 'Please provide a valid list of URLs.'], 400);
        }

        // updating google tests status
        $projectsController->updateGoogleStatus($project_id);


        $testId = Str::uuid();

        $lighthouseTest = LighthouseTest::create([
            'test_id' => $testId,
            'user_id' => 8,
            'project_id' => $project_id,
            'urls' => json_encode($urls),
            'status' => 'in_progress'
        ]);


        // In your controller or main job:
        foreach ($urls as $urlData) {
            RunLighthouseTest::dispatch($lighthouseTest->id, $urlData['url']);
        }


        return response()->json(['testId' => $testId]);
    }

    public function checkStatus($projectId)
    {
        $lighthouseTest = LighthouseTest::where('project_id', $projectId)->first();

        if (!$lighthouseTest) {
            return response()->json(['error' => 'Test ID not found.'], 404);
        }

        return response()->json([
            'status' => $lighthouseTest->status,
            'results' => json_decode($lighthouseTest->results)
        ]);
    }
}
