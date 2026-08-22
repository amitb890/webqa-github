<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\UrlsList;
use App\Models\projectSettings;
use App\Models\SettingsSub;
use App\Rules\CustomURL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Helper;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables; // Import the DataTables class
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\File;
use DOMDocument;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Services\UserActionEventLogger;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
//     public function handleGoogleCallback()
// {
//     $user = Socialite::driver('google')->user();

//     // Check if the user already exists in your database or create a new user.

//     // Log in the user.
//     auth()->login($user);

//     // Redirect to the home page or wherever you want.
//     return redirect('/');
// }
public function handleGoogleCallback(Request $request)
{
    try {
        $socialiteUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        UserActionEventLogger::failed('google_login', 'Google login failed before a user account was resolved.', [
            'source' => 'Google login',
            'error' => $e->getMessage(),
        ], request());

        return redirect('/login')->with('error', 'Google login failed');
    }

    $email = $socialiteUser->getEmail();

    // Soft-deleted accounts must not be recreated or signed in via Google.
    if (User::onlyTrashed()->where('email', $email)->exists()) {
        return redirect('/login')->withErrors([
            'email' => "Looks like you had deleted your account sometime back. Please reach out to <a href='mailto:support@webqa.co'>support@webqa.co</a> to re-instate your account.",
        ]);
    }

    // Check if the user already exists in your database
    $user = User::where('email', $email)->first();
// dd($user);
    // If the user doesn't exist, create a new user
    if (!$user) {
        $user = User::create([
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
        ]);

        event(new Registered($user));
        UserActionEventLogger::success('signup', 'User signed up successfully with Google.', [
            'email' => $user->email,
            'source' => 'Google login',
            'subject_type' => User::class,
            'subject_id' => $user->id,
        ], request(), $user);
    } else {
        UserActionEventLogger::success('google_login', 'User logged in successfully with Google.', [
            'email' => $user->email,
            'source' => 'Google login',
            'subject_type' => User::class,
            'subject_id' => $user->id,
        ], request(), $user);
    }
    Auth::guard('admin')->logout();
    Auth::guard('web')->logout();

    Auth::guard('web')->login($user, true);
    $request->session()->regenerate(true);

    return redirect(RouteServiceProvider::USER);
}

}