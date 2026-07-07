<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserActionEventLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

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
            UserActionEventLogger::failed('signup', 'Signup blocked because this email belongs to a deleted account.', [
                'email' => $request->email,
                'source' => 'Registration form',
            ], $request);

            $successMessage = "Looks like you had deleted your account sometime back. Please reach out to <a href='mailto:support@webqa.co'>support@webqa.co</a> to re-instate your account.";
            session()->flash('alert-class', 'alert-danger alert-danger-custom');
            session()->flash('message', $successMessage);
            return redirect()->back();
        }else{
            $validator = Validator::make($request->all(), [
                'name' => ['nullable', 'string', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9@]+/u'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if ($validator->fails()) {
                UserActionEventLogger::failed('signup', 'Signup validation failed.', [
                    'email' => $request->email,
                    'source' => 'Registration form',
                    'errors' => $validator->errors()->toArray(),
                ], $request);

                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } catch (\Throwable $e) {
                UserActionEventLogger::failed('signup', 'Signup failed while creating the user account.', [
                    'email' => $request->email,
                    'source' => 'Registration form',
                    'error' => $e->getMessage(),
                ], $request);

                throw $e;
            }
    
            event(new Registered($user));
            UserActionEventLogger::success('signup', 'User signed up successfully.', [
                'email' => $user->email,
                'source' => 'Registration form',
                'subject_type' => User::class,
                'subject_id' => $user->id,
            ], $request, $user);
    
            Auth::guard('web')->logout();

            Auth::login($user, true);
            $request->session()->regenerate(true);

            return redirect(RouteServiceProvider::USER);
        }
    }
}
