<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CachedTestController;
use App\Http\Controllers\Api\BrokenLinksController;
use App\Http\Controllers\OnboardingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/start-tests', [App\Http\Controllers\LighthouseController::class, 'startTests']);
Route::get('/check-status/{testId}', [App\Http\Controllers\LighthouseController::class, 'checkStatus']);

Route::get('/cached-test', [CachedTestController::class, 'show']);
Route::post('/cached-test', [CachedTestController::class, 'store']);

// Broken Links API routes
Route::post('/ignore-broken-link', [BrokenLinksController::class, 'ignoreUrl']);
Route::post('/ignore-all-broken-links', [BrokenLinksController::class, 'ignoreAllUrls']);

