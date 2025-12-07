<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CachedTest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
class CachedTestController extends Controller
{
    // GET /api/cached-test?test_key=...
    public function show(Request $request)
    {
        $testKey = $request->query('test_key');
        if (!$testKey) {
            return response()->json(['error' => 'test_key required'], 400);
        }
        $query = CachedTest::where('test_key', $testKey);
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        $cached = $query->first();
        if ($cached) {
            return response()->json([
                'result' => $cached->result,
                'test_labels' => $cached->test_labels,
                'resultsData' => $cached->resultsData,
                'dataFailed' => $cached->dataFailed,
                'dataPassed' => $cached->dataPassed,
                'projectUrl' => $cached->projectUrl,
            ]);
        } else {
            return response()->json([
                'result' => null,
                'test_labels' => null,
                'resultsData' => null,
                'dataFailed' => null,
                'dataPassed' => null,
                'projectUrl' => null,
            ]);
        }
    }


public function store(Request $request)
{
    $request->validate([
        'test_key' => 'required|string',
        'result' => 'required|array',
        'test_labels' => 'nullable',
        'resultsData' => 'nullable',
        'dataFailed' => 'nullable',
        'dataPassed' => 'nullable',
        'projectUrl' => 'nullable|string',
    ]);

    $userId = Auth::check() ? Auth::id() : null;
    
    // ✅ Use projectUrl from AJAX
    $url = $request->projectRoute ?? '';

    $webApp = 0;

    if (Str::endsWith($url, '/analysis-report')) {
        $webApp = 1;
    } elseif (preg_match('/\/analysis-report\/w\/\d+$/', $url)) {
        $webApp = 0;
    }

    $cached = CachedTest::updateOrCreate(
        [
            'test_key' => $request->test_key,
            'user_id' => $userId,
        ],
        [
            'result' => $request->result,
            'test_labels' => $request->test_labels,
            'resultsData' => $request->resultsData,
            'dataFailed' => $request->dataFailed,
            'dataPassed' => $request->dataPassed,
            'projectUrl' => $request->projectUrl,
            'web_app' => $webApp,
        ]
    );

    return response()->json(['success' => true]);
}


} 