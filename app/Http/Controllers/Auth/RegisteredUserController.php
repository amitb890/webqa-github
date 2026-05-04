<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Mail\WelcomeMail;
use App\Support\UserDisplayName;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $is_user = User::onlyTrashed()
                ->where('email', $request->email)->exists();
        if($is_user){
            $successMessage = "Looks like you had deleted your account sometime back. Please reach out to <a href='mailto:support@webqa.co'>support@webqa.co</a> to re-instate your account.";
            session()->flash('alert-class', 'alert-danger alert-danger-custom');
            session()->flash('message', $successMessage);
            return redirect()->back();
        }else{
            $request->validate([
                'name' => ['nullable', 'string', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9@]+/u'],
                'password' => ['required', 'confirmed'],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            $firstName = UserDisplayName::firstName($request->input('name'));

            try {
                Mail::to($request->email)->send(new WelcomeMail([
                    'name' => $request->input('name'),
                    'email' => $request->email,
                    'firstName' => $firstName,
                ]));
            } catch (\Throwable $e) {
                Log::warning('Welcome email failed to send: '.$e->getMessage(), [
                    'user_id' => $user->id,
                    'email' => $request->email,
                ]);
            }

            return redirect(RouteServiceProvider::USER);
        }
    }
}
