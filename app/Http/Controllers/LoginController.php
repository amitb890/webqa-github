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
use App\Models\User; // Make sure to import your User model

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
public function handleGoogleCallback()
{
    try {
        $socialiteUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Google login failed');
    }

    // Check if the user already exists in your database
    $user = User::where('email', $socialiteUser->getEmail())->first();
// dd($user);
    // If the user doesn't exist, create a new user
    if (!$user) {
        $user = User::create([
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
            // 'password' => bcrypt('123456'),

            // Add any other necessary fields
        ]);
    }
    // Log in the user
    auth()->login($user);

    // Redirect to the home page or wherever you want
    return redirect('/dashboard');
}

}