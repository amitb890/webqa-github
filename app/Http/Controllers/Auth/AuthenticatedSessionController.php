<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $is_user = User::onlyTrashed()
                ->where('email', $request->email)->exists();
        if($is_user){
            $successMessage = "Looks like you had deleted your account sometime back. Please reach out to <a href='mailto:support@webqa.co'>support@webqa.co</a> to re-instate your account.";
            session()->flash('alert-class', 'alert-danger alert-danger-custom');
            session()->flash('message', $successMessage);
            return redirect()->back();
        }else{
            $request->authenticate();
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::USER);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
